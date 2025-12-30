const db = require('../config/database');

// Get All Catatan (by current user)
exports.getAllCatatan = async (req, res) => {
    try {
        const { id_siswa, start_date, end_date } = req.query;
        
        let query = `
            SELECT cp.*, s.nama_siswa, k.nama_kelas, u.nama_user as nama_guru
            FROM catatan_perkembangan cp
            LEFT JOIN siswa s ON cp.id_siswa = s.id_siswa
            LEFT JOIN kelas k ON s.id_kelas = k.id_kelas
            LEFT JOIN users u ON cp.id_user = u.id_user
            WHERE cp.id_user = ?
        `;
        const params = [req.user.id_user];

        if (id_siswa) {
            query += ' AND cp.id_siswa = ?';
            params.push(id_siswa);
        }

        if (start_date && end_date) {
            query += ' AND cp.tanggal_catat BETWEEN ? AND ?';
            params.push(start_date, end_date);
        }

        query += ' ORDER BY cp.tanggal_catat DESC';

        const [rows] = await db.query(query, params);

        // Get detail catatan for each
        for (let catatan of rows) {
            const [details] = await db.query(`
                SELECT dc.*, kat.nama_kategori
                FROM detail_catatan dc
                LEFT JOIN kategori kat ON dc.id_kategori = kat.id_kategori
                WHERE dc.id_catatan = ?
            `, [catatan.id_catatan]);
            
            catatan.detail = details;
        }

        res.json({
            success: true,
            message: 'Data catatan berhasil diambil',
            data: rows
        });

    } catch (error) {
        console.error('Get catatan error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};

// Get Catatan by ID
exports.getCatatanById = async (req, res) => {
    try {
        const { id } = req.params;

        const [catatanRows] = await db.query(`
            SELECT cp.*, s.nama_siswa, k.nama_kelas, u.nama_user as nama_guru
            FROM catatan_perkembangan cp
            LEFT JOIN siswa s ON cp.id_siswa = s.id_siswa
            LEFT JOIN kelas k ON s.id_kelas = k.id_kelas
            LEFT JOIN users u ON cp.id_user = u.id_user
            WHERE cp.id_catatan = ? AND cp.id_user = ?
        `, [id, req.user.id_user]);

        if (catatanRows.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Catatan tidak ditemukan'
            });
        }

        const catatan = catatanRows[0];

        // Get detail
        const [details] = await db.query(`
            SELECT dc.*, kat.nama_kategori
            FROM detail_catatan dc
            LEFT JOIN kategori kat ON dc.id_kategori = kat.id_kategori
            WHERE dc.id_catatan = ?
        `, [id]);

        catatan.detail = details;

        res.json({
            success: true,
            message: 'Detail catatan berhasil diambil',
            data: catatan
        });

    } catch (error) {
        console.error('Get catatan by id error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};

// Create Catatan
exports.createCatatan = async (req, res) => {
    const connection = await db.getConnection();
    
    try {
        await connection.beginTransaction();

        const { id_siswa, semester, tahun_ajaran, detail } = req.body;

        // Validation
        if (!id_siswa || !semester || !tahun_ajaran || !detail || !Array.isArray(detail)) {
            return res.status(400).json({
                success: false,
                message: 'Data tidak lengkap'
            });
        }

        // Insert catatan perkembangan
        const [result] = await connection.query(`
            INSERT INTO catatan_perkembangan (
                id_user, id_siswa, tanggal_catat, semester, tahun_ajaran,
                created_at, updated_at
            ) VALUES (?, ?, NOW(), ?, ?, NOW(), NOW())
        `, [req.user.id_user, id_siswa, semester, tahun_ajaran]);

        const id_catatan = result.insertId;

        // Insert detail catatan
        for (let item of detail) {
            if (item.deskripsi && item.deskripsi.trim() !== '') {
                await connection.query(`
                    INSERT INTO detail_catatan (
                        id_catatan, id_kategori, deskripsi,
                        created_at, updated_at
                    ) VALUES (?, ?, ?, NOW(), NOW())
                `, [id_catatan, item.id_kategori, item.deskripsi]);
            }
        }

        await connection.commit();

        // Get created catatan
        const [newCatatan] = await db.query(`
            SELECT cp.*, s.nama_siswa
            FROM catatan_perkembangan cp
            LEFT JOIN siswa s ON cp.id_siswa = s.id_siswa
            WHERE cp.id_catatan = ?
        `, [id_catatan]);

        res.status(201).json({
            success: true,
            message: 'Catatan berhasil ditambahkan',
            data: newCatatan[0]
        });

    } catch (error) {
        await connection.rollback();
        console.error('Create catatan error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    } finally {
        connection.release();
    }
};

// Update Catatan
exports.updateCatatan = async (req, res) => {
    const connection = await db.getConnection();
    
    try {
        await connection.beginTransaction();

        const { id } = req.params;
        const { id_siswa, semester, tahun_ajaran, detail } = req.body;

        // Update catatan perkembangan
        await connection.query(`
            UPDATE catatan_perkembangan SET
                id_siswa = ?, semester = ?, tahun_ajaran = ?,
                updated_at = NOW()
            WHERE id_catatan = ? AND id_user = ?
        `, [id_siswa, semester, tahun_ajaran, id, req.user.id_user]);

        // Delete old details
        await connection.query('DELETE FROM detail_catatan WHERE id_catatan = ?', [id]);

        // Insert new details
        for (let item of detail) {
            if (item.deskripsi && item.deskripsi.trim() !== '') {
                await connection.query(`
                    INSERT INTO detail_catatan (
                        id_catatan, id_kategori, deskripsi,
                        created_at, updated_at
                    ) VALUES (?, ?, ?, NOW(), NOW())
                `, [id, item.id_kategori, item.deskripsi]);
            }
        }

        await connection.commit();

        res.json({
            success: true,
            message: 'Catatan berhasil diupdate'
        });

    } catch (error) {
        await connection.rollback();
        console.error('Update catatan error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    } finally {
        connection.release();
    }
};

// Delete Catatan
exports.deleteCatatan = async (req, res) => {
    try {
        const { id } = req.params;

        await db.query(`
            DELETE FROM catatan_perkembangan 
            WHERE id_catatan = ? AND id_user = ?
        `, [id, req.user.id_user]);

        res.json({
            success: true,
            message: 'Catatan berhasil dihapus'
        });

    } catch (error) {
        console.error('Delete catatan error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};

// Get Kategori
exports.getKategori = async (req, res) => {
    try {
        const [rows] = await db.query('SELECT * FROM kategori ORDER BY id_kategori');

        res.json({
            success: true,
            message: 'Data kategori berhasil diambil',
            data: rows
        });

    } catch (error) {
        console.error('Get kategori error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};