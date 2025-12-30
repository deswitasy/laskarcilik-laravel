const express = require('express');
const router = express.Router();
const siswaController = require('../controllers/siswaController');
const authMiddleware = require('../middleware/authMiddleware');

router.get('/', authMiddleware, siswaController.getAllSiswa);
router.get('/:id', authMiddleware, siswaController.getSiswaById);
router.post('/', authMiddleware, siswaController.createSiswa);
router.put('/:id', authMiddleware, siswaController.updateSiswa);
router.delete('/:id', authMiddleware, siswaController.deleteSiswa);

module.exports = router;