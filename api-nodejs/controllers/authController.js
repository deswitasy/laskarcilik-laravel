const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const db = require('../config/database');

// Login
exports.login = async (req, res) => {
    try {
        const { username, password } = req.body;

        // Validation
        if (!username || !password) {
            return res.status(400).json({
                success: false,
                message: 'Username dan password harus diisi'
            });
        }

        // Check user in database
        const [rows] = await db.query(
            'SELECT * FROM users WHERE username = ? AND status = ?',
            [username, 'aktif']
        );

        if (rows.length === 0) {
            return res.status(401).json({
                success: false,
                message: 'Username atau password salah'
            });
        }

        const user = rows[0];

        // Verify password (Laravel uses bcrypt)
        const isPasswordValid = await bcrypt.compare(password, user.password);

        if (!isPasswordValid) {
            return res.status(401).json({
                success: false,
                message: 'Username atau password salah'
            });
        }

        // Generate JWT token
        const token = jwt.sign(
            {
                id_user: user.id_user,
                username: user.username,
                nama_user: user.nama_user,
                hak_akses: user.hak_akses
            },
            process.env.JWT_SECRET,
            { expiresIn: process.env.JWT_EXPIRES_IN }
        );

        res.json({
            success: true,
            message: 'Login berhasil',
            data: {
                user: {
                    id: user.id_user,
                    nama: user.nama_user,
                    username: user.username,
                    email: user.email,
                    role: user.hak_akses
                },
                token: token
            }
        });

    } catch (error) {
        console.error('Login error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};

// Get Profile
exports.profile = async (req, res) => {
    try {
        const [rows] = await db.query(
            'SELECT id_user, nama_user, username, email, no_hp, hak_akses FROM users WHERE id_user = ?',
            [req.user.id_user]
        );

        if (rows.length === 0) {
            return res.status(404).json({
                success: false,
                message: 'User tidak ditemukan'
            });
        }

        res.json({
            success: true,
            message: 'Profile berhasil diambil',
            data: rows[0]
        });

    } catch (error) {
        console.error('Profile error:', error);
        res.status(500).json({
            success: false,
            message: 'Terjadi kesalahan server',
            error: error.message
        });
    }
};