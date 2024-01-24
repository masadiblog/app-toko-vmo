/* grup */
CREATE TABLE IF NOT EXISTS tb_grup(
id_grup INT(11) NOT NULL AUTO_INCREMENT,
nama VARCHAR(30) NOT NULL,
PRIMARY KEY(id_grup)
);

/* admin */
CREATE TABLE IF NOT EXISTS tb_admin(
id_admin INT(11) NOT NULL AUTO_INCREMENT,
id_grup INT(11) NOT NULL,
id_toko INT(11) NOT NULL,
username VARCHAR(30) NOT NULL,
password VARCHAR(255) NOT NULL,
level VARCHAR(20) NOT NULL,
PRIMARY KEY(id_admin)
);

/* toko */
CREATE TABLE IF NOT EXISTS tb_toko(
id_toko INT(11) NOT NULL AUTO_INCREMENT,
id_grup INT(11) NOT NULL,
nama VARCHAR(30) NOT NULL,
PRIMARY KEY(id_toko)
);

/* modal */
CREATE TABLE IF NOT EXISTS tb_modal(
id_modal INT(11) NOT NULL AUTO_INCREMENT,
id_grup INT(11) NOT NULL,
id_toko INT(11) NOT NULL,
nama VARCHAR(30) NOT NULL,
modal VARCHAR(10) NOT NULL,
PRIMARY KEY(id_modal)
);

/* penjualan */
CREATE TABLE IF NOT EXISTS tb_penjualan(
id_penjualan INT(11) NOT NULL AUTO_INCREMENT,
id_grup INT(11) NOT NULL,
id_toko INT(11) NOT NULL,
nama VARCHAR(30) NOT NULL,
harga VARCHAR(10) NOT NULL,
jumlah VARCHAR(5) NOT NULL,
modal VARCHAR(10) NOT NULL,
laba VARCHAR(10) NOT NULL,
tanggal VARCHAR(2) NOT NULL,
bulan VARCHAR(12) NOT NULL,
tahun VARCHAR(5) NOT NULL,
PRIMARY KEY(id_penjualan)
);

/* pengeluaran */
CREATE TABLE IF NOT EXISTS tb_pengeluaran(
id_pengeluaran INT(11) NOT NULL AUTO_INCREMENT,
id_grup INT(11) NOT NULL,
id_toko INT(11) NOT NULL,
pengeluaran VARCHAR(10) NOT NULL,
keterangan TEXT NOT NULL,
tanggal VARCHAR(2) NOT NULL,
bulan VARCHAR(12) NOT NULL,
tahun VARCHAR(5) NOT NULL,
PRIMARY KEY(id_pengeluaran)
);

/* catatan */
CREATE TABLE IF NOT EXISTS tb_catatan(
id_catatan INT(11) NOT NULL AUTO_INCREMENT,
id_grup INT(11) NOT NULL,
id_toko INT(11) NOT NULL,
judul VARCHAR(50) NOT NULL,
catatan TEXT NOT NULL,
tanggal VARCHAR(2) NOT NULL,
bulan VARCHAR(12) NOT NULL,
tahun VARCHAR(5) NOT NULL,
PRIMARY KEY(id_catatan)
);