/////li dar shi changement yzido ////

to delete a table wih constraint:DROP TABLE brands CASCADE CONSTRAINTS;
CREATE SEQUENCE ma_sequence_abonne;
create table abonne(
	id_abonne  NUMBER DEFAULT ma_sequence_abonne.NEXTVAL,
	nom_abonne Varchar2(25),
	prenom_abonne Varchar2(25),
    username_abonne Varchar2(25),
    password_abonne Varchar2(25),
	adresse_abonne Varchar2(50),
	telephone_abonne Varchar2(25),
	date_adhesion_abonne Varchar2(25),
	date_naissance_abonne Varchar2(25),
    categorie_abonne Varchar2(25)
);
Alter table abonne Add PRIMARY KEY(id_abonne);

create table auteur(
	id_auteur Number(10) not null,
	nom_auteur Varchar2(25),
	prenom_auteur Varchar2(25),
	PRIMARY KEY(id_auteur)
);

create table editeur(
	id_editeur Number(10) not null,
	type_editeur Varchar2(25),
	prenom_auteur Varchar2(25),
	PRIMARY KEY(id_editeur)
);

create table genre(
	id_genre Number(10) not null,
	libelle_genre Varchar2(25),
	PRIMARY KEY(id_genre)
);
create table livre(
	id_livre Number(10)not null,
	titre_livre Varchar2(25),
	code_catalogue Varchar2(25),
	code_rayon Varchar2(25),
	id_auteur Number(10),
	id_genre Number(10),
	id_editeur Number(10),
	PRIMARY KEY(id_livre),
	FOREIGN KEY(id_auteur) REFERENCES auteur(id_auteur),
	FOREIGN KEY(id_genre) REFERENCES genre(id_genre),
	FOREIGN KEY(id_editeur) REFERENCES editeur(id_editeur)
);

create table pret(
	id_pret Number(10) not null,
	date_pret DATE,
	date_retour DATE,
	id_abonne Number(10),
	PRIMARY KEY(id_pret),
	FOREIGN KEY(id_abonne) REFERENCES abonne(id_abonne)
);

create table exemplaire (
	id_exemplaire Number(10) not null,
	code_catalogue Varchar2(25),
	code_rayon Varchar2(25),	
	date_acquisition DATE,
	id_livre Number(10),
	id_editeur Number(10),
	PRIMARY KEY(id_exemplaire),
  	FOREIGN KEY(id_livre) REFERENCES livre(id_livre),
	FOREIGN KEY(id_editeur) REFERENCES editeur(id_editeur)
);

create table abonne_livre(
	id_livre_abonne Number(10),
	id_abonne Number(10),
	id_livre Number(10),
	PRIMARY KEY(id_livre_abonne),
  	FOREIGN KEY(id_abonne) REFERENCES abonne(id_abonne),
	FOREIGN KEY(id_livre) REFERENCES livre(id_livre)
);