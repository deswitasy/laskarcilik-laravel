const express = require('express');
const router = express.Router();
const catatanController = require('../controllers/catatanController');
const authMiddleware = require('../middleware/authMiddleware');

router.get('/', authMiddleware, catatanController.getAllCatatan);
router.get('/kategori', authMiddleware, catatanController.getKategori);
router.get('/:id', authMiddleware, catatanController.getCatatanById);
router.post('/', authMiddleware, catatanController.createCatatan);
router.put('/:id', authMiddleware, catatanController.updateCatatan);
router.delete('/:id', authMiddleware, catatanController.deleteCatatan);

module.exports = router;