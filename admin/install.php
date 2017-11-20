<?php
/**
 * Created by PhpStorm.
 * User: ldorier
 * Date: 30.10.2017
 * Time: 14:40
 */

if ( !defined( 'ABSPATH' ) ) die();

global $wpdb;
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$nom_table = $wpdb->prefix . 'bvg_matches';
$sql = "CREATE TABLE $nom_table (
  id bigint(20) unsigned NOT NULL auto_increment,
  player1_id bigint(20) unsigned NOT NULL,
  player2_id bigint(20) unsigned NOT NULL,
  player1_id_bis bigint(20) unsigned NOT NULL,
  player2_id_bis bigint(20) unsigned NOT NULL,
  tournament_id bigint(20) unsigned NOT NULL,
  round int(11) NOT NULL,
  winner int(11) NOT NULL,
  pl1_set1 int(11) NOT NULL,
  pl2_set1 int(11) NOT NULL,
  pl1_set2 int(11) NOT NULL,
  pl2_set2 int(11) NOT NULL,
  pl1_set3 int(11) NOT NULL,
  pl2_set3 int(11) NOT NULL,
  pl1_set4 int(11) NOT NULL,
  pl2_set4 int(11) NOT NULL,
  pl1_set5 int(11) NOT NULL,
  pl2_set5 int(11) NOT NULL,
  parent_id int(11) NOT NULL,
  PRIMARY KEY (id)
);";
dbDelta( $sql );

$nom_table = $wpdb->prefix . 'bvg_players';
$sql = "CREATE TABLE $nom_table (
  id bigint(20) unsigned NOT NULL auto_increment,
  firstname varchar(150) NOT NULL,
  lastname varchar(150) NOT NULL,
  player_level int(6) unsigned NOT NULL,
  status int(6) unsigned NOT NULL,
  PRIMARY KEY (id)
);";
dbDelta( $sql );

$nom_table = $wpdb->prefix . 'bvg_players_tournament';
$sql = "CREATE TABLE $nom_table (
  id bigint(20) unsigned NOT NULL auto_increment,
  tournament_id bigint(20) unsigned NOT NULL,
  players_id bigint(20) unsigned NOT NULL,
  played int(3) unsigned NOT NULL,
  player_level_init int(3) unsigned NOT NULL,
  player_level_current int(3) unsigned NOT NULL,
  victory int(3) unsigned NOT NULL,
  draw int(3) unsigned NOT NULL,
  loss int(3) unsigned NOT NULL,
  points_major int(3) unsigned NOT NULL,
  sets int(3) unsigned NOT NULL,
  sets_against int(3) unsigned NOT NULL,
  points int(6) unsigned NOT NULL,
  points_against int(6) unsigned NOT NULL,
  opponents varchar(250) NOT NULL,
  PRIMARY KEY (id)
);";
dbDelta( $sql );

$nom_table = $wpdb->prefix . 'bvg_tournaments';
$sql = "CREATE TABLE $nom_table (
  id bigint(20) unsigned NOT NULL auto_increment,
  parent_id int(11) unsigned NOT NULL,
  name varchar(150) NOT NULL,
  round int(11) NOT NULL,
  system int(11) NOT NULL,
  nb_sets int(11) NOT NULL,
  points_set int(11) NOT NULL,
  max_points_set int(11) NOT NULL,
  PRIMARY KEY (id)
);";
dbDelta( $sql );

$bvg_admin_msg = 'Plugin BVG Turnier installiert !';



/*

-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Nov 2017 um 15:19
-- Server-Version: 5.7.11
-- PHP-Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: bvg_dev
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle wp_bvg_matches
--

CREATE TABLE wp_bvg_matches (
  id bigint(20) NOT NULL,
  player1_id bigint(20) NOT NULL,
  player2_id bigint(20) NOT NULL,
  tournament_id bigint(20) NOT NULL,
  round int(11) NOT NULL,
  winner int(11) NOT NULL,
  pl1_set1 int(11) NOT NULL,
  pl2_set1 int(11) NOT NULL,
  pl1_set2 int(11) NOT NULL,
  pl2_set2 int(11) NOT NULL,
  pl1_set3 int(11) NOT NULL,
  pl2_set3 int(11) NOT NULL,
  pl1_set4 int(11) NOT NULL,
  pl2_set4 int(11) NOT NULL,
  pl1_set5 int(11) NOT NULL,
  pl2_set5 int(11) NOT NULL,
  parent_id int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle wp_bvg_players
--

CREATE TABLE wp_bvg_players (
  id bigint(20) UNSIGNED NOT NULL,
  firstname varchar(150) NOT NULL,
  lastname varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle wp_bvg_players_tournament
--

CREATE TABLE wp_bvg_players_tournament (
  id bigint(20) UNSIGNED NOT NULL,
  tournament_id bigint(20) UNSIGNED NOT NULL,
  players_id bigint(20) UNSIGNED NOT NULL,
  player_level_init int(11) NOT NULL,
  player_level_current int(11) NOT NULL,
  played int(3) UNSIGNED NOT NULL,
  victory int(3) UNSIGNED NOT NULL,
  draw int(3) UNSIGNED NOT NULL,
  loss int(3) UNSIGNED NOT NULL,
  points_major int(3) UNSIGNED NOT NULL,
  sets int(3) UNSIGNED NOT NULL,
  sets_against int(11) NOT NULL,
  points int(6) UNSIGNED NOT NULL,
  points_against int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle wp_bvg_tournaments
--

CREATE TABLE wp_bvg_tournaments (
  id bigint(20) NOT NULL,
  parent_id int(11) NOT NULL,
  name varchar(150) NOT NULL,
  round int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle wp_bvg_matches
--
ALTER TABLE wp_bvg_matches
  ADD PRIMARY KEY (id);

--
-- Indizes für die Tabelle wp_bvg_players
--
ALTER TABLE wp_bvg_players
  ADD PRIMARY KEY (id);

--
-- Indizes für die Tabelle wp_bvg_players_tournament
--
ALTER TABLE wp_bvg_players_tournament
  ADD PRIMARY KEY (id);

--
-- Indizes für die Tabelle wp_bvg_tournaments
--
ALTER TABLE wp_bvg_tournaments
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle wp_bvg_matches
--
ALTER TABLE wp_bvg_matches
  MODIFY id bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT für Tabelle wp_bvg_players
--
ALTER TABLE wp_bvg_players
  MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT für Tabelle wp_bvg_players_tournament
--
ALTER TABLE wp_bvg_players_tournament
  MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle wp_bvg_tournaments
--
ALTER TABLE wp_bvg_tournaments
  MODIFY id bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

*/

