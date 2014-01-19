CREATE TABLE status_korisnika (
  idstatus INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  opis VARCHAR(50) NULL,
  PRIMARY KEY(idstatus)
)
TYPE=InnoDB;

CREATE TABLE tip_korisnika (
  idtip INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  naziv VARCHAR(50) NULL,
  PRIMARY KEY(idtip)
)
TYPE=InnoDB;

CREATE TABLE korisnik (
  idkorisnik INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  status_korisnika_idstatus INTEGER UNSIGNED NOT NULL,
  tip_korisnika_idtip INTEGER UNSIGNED NOT NULL,
  ime VARCHAR(50) NULL,
  prezime VARCHAR(50) NULL,
  e_mail VARCHAR(50) NULL,
  adresa VARCHAR(50) NULL,
  korisnicko_ime VARCHAR(50) NULL,
  lozinka VARCHAR(50) NULL,
  blokiran_do DATETIME NULL,
  PRIMARY KEY(idkorisnik),
  INDEX korisnik_FKIndex1(tip_korisnika_idtip),
  INDEX korisnik_FKIndex2(status_korisnika_idstatus),
  FOREIGN KEY(tip_korisnika_idtip)
    REFERENCES tip_korisnika(idtip)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(status_korisnika_idstatus)
    REFERENCES status_korisnika(idstatus)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE narudzba (
  idnarudzba INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  korisnik_idkorisnik INTEGER UNSIGNED NOT NULL,
  iznos DECIMAL NULL,
  PRIMARY KEY(idnarudzba),
  INDEX narudzba_FKIndex2(korisnik_idkorisnik),
  FOREIGN KEY(korisnik_idkorisnik)
    REFERENCES korisnik(idkorisnik)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE novosti (
  idnovosti INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  korisnik_idkorisnik INTEGER UNSIGNED NOT NULL,
  novost TEXT NULL,
  datum DATE NULL,
  PRIMARY KEY(idnovosti),
  INDEX novosti_FKIndex1(korisnik_idkorisnik),
  FOREIGN KEY(korisnik_idkorisnik)
    REFERENCES korisnik(idkorisnik)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE automobil (
  idautomobil INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  korisnik_idkorisnik INTEGER UNSIGNED NOT NULL,
  naziv VARCHAR(50) NULL,
  serija VARCHAR(50) NULL,
  tip VARCHAR(50) NULL,
  cijena DECIMAL NULL,
  PRIMARY KEY(idautomobil),
  INDEX automobil_FKIndex1(korisnik_idkorisnik),
  FOREIGN KEY(korisnik_idkorisnik)
    REFERENCES korisnik(idkorisnik)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE dijelovi (
  iddio INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  korisnik_idkorisnik INTEGER UNSIGNED NOT NULL,
  automobil_idautomobil INTEGER UNSIGNED NOT NULL,
  naziv VARCHAR(50) NULL,
  opis VARCHAR(50) NULL,
  cijena DECIMAL NULL,
  PRIMARY KEY(iddio),
  INDEX dijelovi_FKIndex2(automobil_idautomobil),
  INDEX dijelovi_FKIndex2(korisnik_idkorisnik),
  FOREIGN KEY(automobil_idautomobil)
    REFERENCES automobil(idautomobil)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(korisnik_idkorisnik)
    REFERENCES korisnik(idkorisnik)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE konfiguracije (
  idkonfiguracije INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  narudzba_idnarudzba INTEGER UNSIGNED NOT NULL,
  korisnik_idkorisnik INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idkonfiguracije),
  INDEX konfiguracije_FKIndex1(korisnik_idkorisnik),
  INDEX konfiguracije_FKIndex2(narudzba_idnarudzba),
  FOREIGN KEY(korisnik_idkorisnik)
    REFERENCES korisnik(idkorisnik)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(narudzba_idnarudzba)
    REFERENCES narudzba(idnarudzba)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE stavka (
  idstavka INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  dijelovi_iddio INTEGER UNSIGNED NOT NULL,
  konfiguracije_idkonfiguracije INTEGER UNSIGNED NOT NULL,
  automobil_idautomobil INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idstavka),
  INDEX stavka_FKIndex2(automobil_idautomobil),
  INDEX stavka_FKIndex3(dijelovi_iddio),
  INDEX stavka_FKIndex3(konfiguracije_idkonfiguracije),
  FOREIGN KEY(automobil_idautomobil)
    REFERENCES automobil(idautomobil)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(dijelovi_iddio)
    REFERENCES dijelovi(iddio)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(konfiguracije_idkonfiguracije)
    REFERENCES konfiguracije(idkonfiguracije)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE komentar_ocjena (
  idkomocj INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  komentar_ocjena_idkomocj INTEGER UNSIGNED NOT NULL,
  konfiguracije_idkonfiguracije INTEGER UNSIGNED NOT NULL,
  korisnik_idkorisnik INTEGER UNSIGNED NOT NULL,
  automobil_idautomobil INTEGER UNSIGNED NOT NULL,
  dijelovi_iddio INTEGER UNSIGNED NOT NULL,
  datum DATETIME NULL,
  tekst TEXT NULL,
  ocjena INTEGER UNSIGNED NULL,
  PRIMARY KEY(idkomocj),
  INDEX komentar_FKIndex1(dijelovi_iddio),
  INDEX komentar_FKIndex2(automobil_idautomobil),
  INDEX komentar_FKIndex3(korisnik_idkorisnik),
  INDEX komentar_FKIndex4(konfiguracije_idkonfiguracije),
  INDEX komentar_ocjena_FKIndex5(komentar_ocjena_idkomocj),
  FOREIGN KEY(dijelovi_iddio)
    REFERENCES dijelovi(iddio)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(automobil_idautomobil)
    REFERENCES automobil(idautomobil)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(korisnik_idkorisnik)
    REFERENCES korisnik(idkorisnik)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(konfiguracije_idkonfiguracije)
    REFERENCES konfiguracije(idkonfiguracije)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(komentar_ocjena_idkomocj)
    REFERENCES komentar_ocjena(idkomocj)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE slika (
  idslika INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  automobil_idautomobil INTEGER UNSIGNED NOT NULL,
  dijelovi_iddio INTEGER UNSIGNED NOT NULL,
  path VARCHAR(100) NULL,
  PRIMARY KEY(idslika),
  INDEX slika_FKIndex1(dijelovi_iddio),
  INDEX slika_FKIndex2(automobil_idautomobil),
  FOREIGN KEY(dijelovi_iddio)
    REFERENCES dijelovi(iddio)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(automobil_idautomobil)
    REFERENCES automobil(idautomobil)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
)
TYPE=InnoDB;


