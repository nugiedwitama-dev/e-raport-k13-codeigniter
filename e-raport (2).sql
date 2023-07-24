-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2023 at 11:14 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-raport`
--

-- --------------------------------------------------------

--
-- Table structure for table `filter_nilai`
--

CREATE TABLE `filter_nilai` (
  `id` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `tahun_ajaran` varchar(50) NOT NULL,
  `kelas` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `filter_nilai`
--

INSERT INTO `filter_nilai` (`id`, `id_mapel`, `tahun_ajaran`, `kelas`) VALUES
(1, 1, '2023/2024', 'IX B');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nama_guru` varchar(50) NOT NULL,
  `whatsapp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`, `whatsapp`) VALUES
(3, 'Ney', '082138668809'),
(4, 'Naelyyyyy', '082324462600'),
(5, 'Alfi Romadhon, S.Pd', '08xx'),
(6, 'Dina Fadzilah Andini, S.Pd', '08xx'),
(7, 'Umi Kusumaningsih, S.Pd', '08xx'),
(8, 'Ely Supri Rahayu, S.Pd', '08xx'),
(9, 'Ardiana Rossi Utami, S.Pd', '08xx'),
(10, 'Aris Pramudiyo, S.E', '08xx'),
(11, 'Tri Wahyu P, S.Pd, M.Si', '08xx'),
(12, 'Sofiana SE, S.Pd, SD', '08xx'),
(14, 'Rujiono Dwi Purwanto, S.Kom', '08xx'),
(15, 'Fiki Wardhani, A.Md', '08xx'),
(16, 'Sri Lestari, S.E', '08xx'),
(17, 'Siwan', '08xx');

-- --------------------------------------------------------

--
-- Table structure for table `idraport`
--

CREATE TABLE `idraport` (
  `id` int(11) NOT NULL,
  `id_siswa` varchar(50) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `thn_ajaran` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `idraport`
--

INSERT INTO `idraport` (`id`, `id_siswa`, `id_mapel`, `kelas`, `thn_ajaran`) VALUES
(1, '003', 1, 'IX A', '2023/2024');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(11) NOT NULL,
  `mata_pelajaran` varchar(50) NOT NULL,
  `skk` int(11) NOT NULL,
  `kkm` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `mata_pelajaran`, `skk`, `kkm`, `id_guru`) VALUES
(1, 'BAHASA INDONESIA', 1, 70, 7),
(3, 'BAHASA INGGRIS', 2, 70, 8);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `id_siswa` varchar(10) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `thn_ajaran` varchar(50) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `nilai_tm_1` int(11) DEFAULT 0,
  `nilai_tm_2` int(11) DEFAULT 0,
  `nilai_tm_3` int(11) DEFAULT 0,
  `nilai_tm_4` int(11) DEFAULT 0,
  `nilai_tm_5` int(11) DEFAULT 0,
  `rata_rata_tm` int(11) DEFAULT 0,
  `nilai_mandiri` int(11) DEFAULT 0,
  `uts` int(11) DEFAULT 0,
  `rata_rata_tm_uts` int(11) DEFAULT 0,
  `nilai_smt` int(11) DEFAULT 0,
  `sikap` varchar(5) DEFAULT NULL,
  `nilai_raport` int(11) DEFAULT 0,
  `jumlah` int(11) NOT NULL,
  `ket` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `id_siswa`, `id_mapel`, `thn_ajaran`, `id_guru`, `kelas`, `nilai_tm_1`, `nilai_tm_2`, `nilai_tm_3`, `nilai_tm_4`, `nilai_tm_5`, `rata_rata_tm`, `nilai_mandiri`, `uts`, `rata_rata_tm_uts`, `nilai_smt`, `sikap`, `nilai_raport`, `jumlah`, `ket`) VALUES
(1, '001', 1, '2023/2024', 4, 'IX A', 90, 80, 78, 90, 85, 85, 77, 82, 83, 78, 'B', 81, 741, 'Tuntas'),
(5, '001', 3, '2023/2024', 3, 'IX A', 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 'B', 50, 0, 'Tidak Tuntas'),
(6, '002', 1, '2023/2024', 3, 'IX A', 95, 85, 90, 92, 88, 90, 87, 88, 89, 94, 'A', 90, 809, 'Tuntas'),
(7, '003', 1, '2023/2024', 4, 'IX A', 75, 76, 74, 77, 73, 75, 78, 72, 75, 79, 'B', 71, 675, 'Tuntas'),
(8, '003', 3, '2023/2024', 3, 'IX A', 90, 80, 85, 75, 95, 85, 88, 89, 86, 85, 'B', 84, 771, 'Tuntas');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nis` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `password`, `nis`, `nama`, `kelas`, `alamat`, `telp`) VALUES
('001', 'siswa', '112233', 'Neila', 'PAKET B KELAS 11', 'Jl Raya ...', '08888888888'),
('002', 'siswa', '212122', 'Naelyyyyyyyyyyyyyy', 'IX B', 'Jl Raya Idul Fitri', '082181618129'),
('003', '123', '22222', 'Naely noer rokhmah', 'IX A', 'Jl Raya ...', '08');

-- --------------------------------------------------------

--
-- Table structure for table `tahun_ajaran`
--

CREATE TABLE `tahun_ajaran` (
  `thn_ajaran` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tahun_ajaran`
--

INSERT INTO `tahun_ajaran` (`thn_ajaran`, `semester`) VALUES
('2023/2024', 'Ganjil');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `alamat`, `no_telp`, `image`, `password`, `role_id`, `is_active`, `date_created`) VALUES
(5, 'Naely Noer Rokhmah', 'naelibbs@gmail.com', 'Krangean, Kertanegara, Purbalingga', '082324462600', 'default.jpg', '$2y$10$oN5yNO65c50ibmyGjBvKre4HKYuVrIurCYosumvSgQ6UFniVvUDXC', 1, 1, 1683389912),
(6, 'Lehorista Anjayani', 'lehorista1800@gmail.com', 'Purwosari, Baturaden, Banyumas', '08123456712', 'default.jpg', '$2y$10$rTf4POonRkwy8g7b4lO/V.8NfN7/8ABLpO/wa4ZRUR8rQnQDUe0Pu', 2, 1, 1683390424),
(7, 'Nnnr', 'agyayg@dardra.cudsh', 'Jawa Tengah', '082345678919', '', 'admin123', 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(3, 2, 2),
(8, 1, 2),
(10, 1, 3),
(11, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Guru');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(3, 2, 'Profil', 'user', 'fas fa-fw fa-user', 1),
(4, 3, 'Manajemen', 'menu', 'fas fa-fw fa-toolbox', 1),
(7, 3, 'Submenu Manajemen', 'menu/submenu', 'fas fa-fw fa-wrench', 1),
(9, 1, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(11, 2, 'Edit Profil', 'user/edit', 'fas fa-fw fa-pen', 1),
(13, 2, 'Ubah Password', 'user/ubahpassword', 'fas fa-fw fa-lock', 1),
(16, 1, 'User Akses', 'admin/user_akses', 'fas fa-fw fa-universal-access', 1),
(19, 1, 'Siswa', 'admin/siswa', 'fas fa-fw fa-users', 1),
(20, 1, 'Guru', 'admin/guru', 'fas fa-fw fa-user-graduate', 1),
(21, 1, 'Kelas', 'admin/kelas', 'fas fa-fw fa-tasks', 1),
(22, 1, 'Nilai', 'admin/nilai', 'fas fa-fw fa-book', 1),
(24, 2, 'Nilai', 'user/nilai', 'fas fa-fw fa-book', 1),
(25, 1, 'Raport', 'admin/raport', 'fas fa-fw fa-file-pdf', 1),
(26, 2, 'Raport', 'user/raport', 'fas fa-fw fa-file-pdf', 1),
(27, 1, 'Mata Pelajaran', 'admin/mapel', 'fas fa-fw fa-calendar', 1),
(28, 1, 'Tahun Ajaran', 'admin/thn_ajaran', 'fas fa-fw fa-clock', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wali_kelas`
--

CREATE TABLE `wali_kelas` (
  `id_kelas` int(11) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `id_guru` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wali_kelas`
--

INSERT INTO `wali_kelas` (`id_kelas`, `kelas`, `id_guru`) VALUES
(3, 'IX A', 4),
(4, 'IX B', 3),
(1, 'PAKET B KELAS 11', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `filter_nilai`
--
ALTER TABLE `filter_nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matapel` (`id_mapel`),
  ADD KEY `ajar` (`tahun_ajaran`),
  ADD KEY `tingkat` (`kelas`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `idraport`
--
ALTER TABLE `idraport`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thn_ajar` (`thn_ajaran`),
  ADD KEY `kelass` (`kelas`),
  ADD KEY `mapel` (`id_mapel`),
  ADD KEY `siswa` (`id_siswa`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idsiswa` (`id_siswa`),
  ADD KEY `idmapel` (`id_mapel`),
  ADD KEY `thnajaran` (`thn_ajaran`),
  ADD KEY `idguru` (`id_guru`),
  ADD KEY `kelas` (`kelas`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `kelas` (`kelas`);

--
-- Indexes for table `tahun_ajaran`
--
ALTER TABLE `tahun_ajaran`
  ADD PRIMARY KEY (`thn_ajaran`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wali_kelas`
--
ALTER TABLE `wali_kelas`
  ADD PRIMARY KEY (`kelas`),
  ADD UNIQUE KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_guru` (`id_guru`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `filter_nilai`
--
ALTER TABLE `filter_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `idraport`
--
ALTER TABLE `idraport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `wali_kelas`
--
ALTER TABLE `wali_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `filter_nilai`
--
ALTER TABLE `filter_nilai`
  ADD CONSTRAINT `ajar` FOREIGN KEY (`tahun_ajaran`) REFERENCES `tahun_ajaran` (`thn_ajaran`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `matapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tingkat` FOREIGN KEY (`kelas`) REFERENCES `wali_kelas` (`kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `idraport`
--
ALTER TABLE `idraport`
  ADD CONSTRAINT `kelass` FOREIGN KEY (`kelas`) REFERENCES `wali_kelas` (`kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thn_ajar` FOREIGN KEY (`thn_ajaran`) REFERENCES `tahun_ajaran` (`thn_ajaran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mapel`
--
ALTER TABLE `mapel`
  ADD CONSTRAINT `id_guru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `idguru` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idmapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `idsiswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kelas` FOREIGN KEY (`kelas`) REFERENCES `wali_kelas` (`kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `thnajaran` FOREIGN KEY (`thn_ajaran`) REFERENCES `tahun_ajaran` (`thn_ajaran`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
