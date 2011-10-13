-- Table: dat.logbook

-- DROP TABLE dat.logbook;

CREATE TABLE dat.logbook
(
  pk serial NOT NULL,
  username character varying(255) NOT NULL,
  data date,
  depplace character varying(4),
  arrplace character varying(4),
  deptime timestamp without time zone NOT NULL,
  arrtime timestamp without time zone,
  acftmodel character varying(255),
  acftreg character varying(7),
  spt character varying(1),
  multipilot integer,
  totalflighttime integer,
  picname character varying(255),
  today integer,
  tonight integer,
  ldgday integer,
  ldgnight integer,
  nighttime integer,
  ifrtime integer,
  pictime integer,
  coptime integer,
  dualtime integer,
  instrtime integer,
  rmks character varying(16535),
  CONSTRAINT logbook_pk PRIMARY KEY (pk)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE dat.logbook OWNER TO prjadmin;

