CREATE EXTENSION "uuid-ossp";

BEGIN;

CREATE TABLE base (
    key SERIAL NOT NULL,
    id UUID NOT NULL DEFAULT uuid_generate_v4(),
    is_active BOOLEAN NOT NULL DEFAULT TRUE,

    name VARCHAR(40) NOT NULL,
    working_language VARCHAR(10),

    PRIMARY KEY (key),
    UNIQUE (id)
);

CREATE TABLE entry (
    key INTEGER NOT NULL,
    id VARCHAR(100) NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,

    data JSONB NOT NULL,

    PRIMARY KEY (key, id, is_active),
    FOREIGN KEY(key) REFERENCES base (key)
);

CREATE TABLE person (
    key INTEGER NOT NULL,
    id VARCHAR(100) NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,

    data JSONB NOT NULL,

    PRIMARY KEY (key, id, is_active),
    FOREIGN KEY(key) REFERENCES base (key)
);

COMMIT;

