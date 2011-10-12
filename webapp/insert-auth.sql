campi

1			'mandamento'
2			'data'
3			'au'
4			'ragsoc'
5			'rea'
6			'indirizzo'
7			'protocollo'
8			'pec_attiva'
9			'cns_richiesta'
10			'cns_attiva'
11			'comunica_incarico'
16			'comunica_invia'
12			'comunica_evasa'
13			'note'
14			'chiusura'


ruoli


admin
oper
ro
attiv

valori 

rw -> w
r  -> r


INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('mandamento', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('mandamento', 'oper',  'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('mandamento', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('mandamento', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('data', 'admin', 'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('data', 'oper',  'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('data', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('data', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('au', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('au', 'oper',  'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('au', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('au', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('ragsoc', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('ragsoc', 'oper',  'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('ragsoc', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('ragsoc', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('rea', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('rea', 'oper',  'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('rea', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('rea', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('indirizzo', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('indirizzo', 'oper',  'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('indirizzo', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('indirizzo', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('protocollo', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('protocollo', 'oper',  'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('protocollo', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('protocollo', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('pec_attiva', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('pec_attiva', 'oper',  'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('pec_attiva', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('pec_attiva', 'attiv', 'w');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('cns_richiesta', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('cns_richiesta', 'oper',  'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('cns_richiesta', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('cns_richiesta', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('cns_attiva', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('cns_attiva', 'oper',  'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('cns_attiva', 'ro',    'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('cns_attiva', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_incarico', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_incarico', 'oper',  'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_incarico', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_incarico', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_invia', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_invia', 'oper',  'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_invia', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_invia', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_evasa', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_evasa', 'oper',  'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_evasa', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('comunica_evasa', 'attiv', 'r');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('note', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('note', 'oper',  'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('note', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('note', 'attiv', 'w');

INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('chiusura', 'admin', 'w');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('chiusura', 'oper',  'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('chiusura', 'ro',    'r');
INSERT INTO dat.pec_auth(campo, ruolo, auth) VALUES ('chiusura', 'attiv', 'r');


