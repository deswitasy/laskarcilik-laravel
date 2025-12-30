function getCSRFToken() {
  return document.querySelector('meta[name="csrf-token"]').content;
}

// Fetch Helper dengan CSRF Token
async function fetchWithCSRF(url, options = {}) {
  const defaultOptions = {
    headers: {
      'X-CSRF-TOKEN': getCSRFToken(),
      'Accept': 'application/json',
      'Content-Type': 'application/json',
    },
  };

  const mergedOptions = {
    ...defaultOptions,
    ...options,
    headers: {
      ...defaultOptions.headers,
      ...options.headers,
    },
  };

  try {
    const response = await fetch(url, mergedOptions);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Fetch error:', error);
    throw error;
  }
}

// Delete dengan konfirmasi
async function deleteWithConfirm(url, itemName) {
  if (!confirm(`Apakah Anda yakin ingin menghapus "${itemName}"?`)) {
    return;
  }

  try {
    const data = await fetchWithCSRF(url, { method: 'DELETE' });
    
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('Gagal menghapus: ' + data.message);
    }
  } catch (error) {
    alert('Terjadi kesalahan: ' + error);
  }
}
