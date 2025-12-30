const db = require('../config/database');

// Get All Siswa
exports.getAllSiswa = async (req, res) => {
    try {
        const { search, status } = req.query;
        
        let query = `
            SELECT s.*, k.nama_kelas, k.tahun_ajaran
            FROM siswa s
            LEFT JOIN kelas k ON s.id_kelas = k.id_kelas
            WHERE 1=1
        `;
        const params = [];

        if (search) {
            query += ' AND s.nama_siswa LIKE ?';
            params.push(`%${search}%`);
        }

        if (status) {
            query += ' AND s.status_siswa = ?';
            params.push(status);
        }

        query += ' ORDER BY s.nama_siswa';

        const [rows] = await db.query(query, params);

        res.json({
            success: true,
            message: 'Data siswa berhasil diambil',
            data: rows
        });

    } catch (error) {
        console.error('Get siswa error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};

// Get Siswa by ID
exports.getSiswaById = async (req, res) => {
    try {
        const { id } = req.params;

        // Get siswa data
        const [siswaRows] = await db.query(`
            SELECT s.*, k.nama_kelas, k.tahun_ajaran
            FROM siswa s
            LEFT JOIN kelas k ON s.id_kelas = k.id_kelas
            WHERE s.id_siswa = ?
        `, [id]);

        if (siswaRows.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'Siswa tidak ditemukan'
            });
        }

        const siswa = siswaRows[0];

        // Get catatan perkembangan
        const [catatanRows] = await db.query(`
            SELECT cp.*, u.nama_user as nama_guru
            FROM catatan_perkembangan cp
            LEFT JOIN users u ON cp.id_user = u.id_user
            WHERE cp.id_siswa = ?
            ORDER BY cp.tanggal_catat DESC
        `, [id]);

        siswa.catatan_perkembangan = catatanRows;

        res.json({
            success: true,
            message: 'Detail siswa berhasil diambil',
            data: siswa
        });

    } catch (error) {
        console.error('Get siswa by id error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};

// Create Siswa (Admin only)
exports.createSiswa = async (req, res) => {
    try {
        // Check if user is admin
        if (req.user.hak_akses !== 'admin') {
            return res.status(403).json({
                success: false,
                message: 'Hanya admin yang dapat menambah siswa'
            });
        }

        const {
            nama_siswa, id_kelas, jenis_kelamin,
            tanggal_lahir, tempat_lahir,
            nama_ayah, nama_ibu, alamat
        } = req.body;

        // Validation
        if (!nama_siswa || !id_kelas || !jenis_kelamin || !tanggal_lahir || !tempat_lahir) {
            return res.status(400).json({
                success: false,
                message: 'Field wajib harus diisi'
            });
        }

        const [result] = await db.query(`
            INSERT INTO siswa (
                nama_siswa, id_kelas, jenis_kelamin,
                tanggal_lahir, tempat_lahir,
                nama_ayah, nama_ibu, alamat, status_siswa,
                created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'aktif', NOW(), NOW())
        `, [
            nama_siswa, id_kelas, jenis_kelamin,
            tanggal_lahir, tempat_lahir,
            nama_ayah, nama_ibu, alamat
        ]);

        const [newSiswa] = await db.query(
            'SELECT * FROM siswa WHERE id_siswa = ?',
            [result.insertId]
        );

        res.status(201).json({
            success: true,
            message: 'Siswa berhasil ditambahkan',
            data: newSiswa[0]
        });

    } catch (error) {
        console.error('Create siswa error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};

// Update Siswa (Admin only)
exports.updateSiswa = async (req, res) => {
    try {
        if (req.user.hak_akses !== 'admin') {
            return res.status(403).json({
                success: false,
                message: 'Hanya admin yang dapat mengupdate siswa'
            });
        }

        const { id } = req.params;
        const {
            nama_siswa, id_kelas, jenis_kelamin,
            tanggal_lahir, tempat_lahir,
            nama_ayah, nama_ibu, alamat, status_siswa
        } = req.body;

        await db.query(`
            UPDATE siswa SET
                nama_siswa = ?, id_kelas = ?, jenis_kelamin = ?,
                tanggal_lahir = ?, tempat_lahir = ?,
                nama_ayah = ?, nama_ibu = ?, alamat = ?, status_siswa = ?,
                updated_at = NOW()
            WHERE id_siswa = ?
        `, [
            nama_siswa, id_kelas, jenis_kelamin,
            tanggal_lahir, tempat_lahir,
            nama_ayah, nama_ibu, alamat, status_siswa, id
        ]);

        const [updatedSiswa] = await db.query(
            'SELECT * FROM siswa WHERE id_siswa = ?',
            [id]
        );

        res.json({
            success: true,
            message: 'Siswa berhasil diupdate',
            data: updatedSiswa[0]
        });

    } catch (error) {
        console.error('Update siswa error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};

// Delete Siswa (Admin only)
exports.deleteSiswa = async (req, res) => {
    try {
        if (req.user.hak_akses !== 'admin') {
            return res.status(403).json({
                success: false,
                message: 'Hanya admin yang dapat menghapus siswa'
            });
        }

        const { id } = req.params;

        await db.query('DELETE FROM siswa WHERE id_siswa = ?', [id]);

        res.json({
            success: true,
            message: 'Siswa berhasil dihapus'
        });

    } catch (error) {
        console.error('Delete siswa error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};