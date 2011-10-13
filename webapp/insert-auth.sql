-- Table: dat.logbook

-- DROP TABLE dat.logbook;

CREATE TABLE dat.logbook
(
  pk serial NOT NULL,
  data date,
  "depPlace" character varying(4),
  "arrPlace" character varying(4),
  "depTime" timestamp without time zone NOT NULL,
  "arrTime" timestamp without time zone,
  "acftModel" character varying(255),
  "acftReg" character varying(7),
  spt character varying(1),
  "multiPilot" integer,
  "totalFlightTime" integer,
  "picName" character varying(255),
  "toDay" integer,
  "toNight" integer,
  "ldgDay" integer,
  "ldgNight" integer,
  "nightTime" integer,
  "ifrTime" integer,
  "picTime" integer,
  "copTime" integer,
  "dualTime" integer,
  "instrTime" integer,
  rmks character varying(16535),
  "user" character varying(255) NOT NULL,
  CONSTRAINT logbook_pk PRIMARY KEY (pk)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE dat.logbook OWNER TO prjadmin;

