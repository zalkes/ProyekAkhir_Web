var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('tombol-cari');
var container = document.getElementById('container');

function searchData(url, queryParam) {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            container.innerHTML = xhr.responseText;
        }
    }

    xhr.open('GET', url + '?' + queryParam + '=' + keyword.value, true);
    xhr.send();
}

keyword.addEventListener('keyup', function() {
    var currentPage = window.location.pathname;

    if (currentPage.includes('data_pengguna')) {
        searchData('../search/search_pengguna.php', 'keyword');
    } else if (currentPage.includes('data_kamar')) {
        searchData('../search/search_kamar.php', 'keyword');
    } else if (currentPage.includes('data_pesanan')) {
        searchData('../search/search_pesanan.php', 'keyword');
    }
});