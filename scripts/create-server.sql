CREATE TABLE abstract_molecule (
    name VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    PRIMARY KEY(name)
);


CREATE TABLE molecule_attribute (
    abstract_molecule_name VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    value TEXT NOT NULL,
    PRIMARY KEY(abstract_molecule_name, name),
    CONSTRAINT fk_molecule_attribute_name
    FOREIGN KEY(abstract_molecule_name)
    REFERENCES abstract_molecule(name)
    ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE molecule (
    abstract_molecule_name VARCHAR(255) NOT NULL,
    PRIMARY KEY(abstract_molecule_name),
    CONSTRAINT fk_molecule_name
    FOREIGN KEY(abstract_molecule_name)
    REFERENCES abstract_molecule(name)
    ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE protein (
    abstract_molecule_name VARCHAR(255) NOT NULL,
    PRIMARY KEY(abstract_molecule_name),
    CONSTRAINT fk_protein_name
    FOREIGN KEY(abstract_molecule_name)
    REFERENCES abstract_molecule(name)
    ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE TABLE mutated_protein (
    abstract_molecule_name VARCHAR(255) NOT NULL,
    original_protein_name VARCHAR(255) NOT NULL,
    PRIMARY KEY(abstract_molecule_name),
    CONSTRAINT fk_mutated_protein_name
    FOREIGN KEY(abstract_molecule_name)
    REFERENCES abstract_molecule(name)
    ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_mutated_protein_original
    FOREIGN KEY(original_protein_name)
    REFERENCES protein(abstract_molecule_name)
    ON UPDATE CASCADE ON DELETE CASCADE
);
CREATE INDEX mutated_protein_original_index
ON mutated_protein(original_protein_name);



CREATE TABLE function (
    name VARCHAR(255) NOT NULL,
    description TEXT,
    PRIMARY KEY(name)
);


CREATE TABLE function_alteration (
    mutated_protein_name VARCHAR(255) NOT NULL,
    function_NAME VARCHAR(255) NOT NULL,
    type CHAR(1) NOT NULL,
    PRIMARY KEY(mutated_protein_name, function_name),
    CONSTRAINT fk_function_alteration_mutated_protein
    FOREIGN KEY(mutated_protein_name)
    REFERENCES mutated_protein(abstract_molecule_name)
    ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_function_alteration_function
    FOREIGN KEY(function_name)
    REFERENCES function(name)
    ON UPDATE CASCADE ON DELETE CASCADE
);



CREATE TABLE pathology (
    name VARCHAR(255) NOT NULL,
    description TEXT,
    PRIMARY KEY(name)
);


CREATE TABLE mutated_protein_pathology (
    mutated_protein_NAME VARCHAR(255) NOT NULL,
    pathology_NAME VARCHAR(255) NOT NULL,
    PRIMARY KEY(mutated_protein_name, pathology_name),
    CONSTRAINT fk_mutated_protein_pathology_mutated_protein
    FOREIGN KEY(mutated_protein_name)
    REFERENCES mutated_protein(abstract_molecule_name)
    ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_mutated_protein_pathology_pathology
    FOREIGN KEY(pathology_name)
    REFERENCES pathology(name)
    ON UPDATE CASCADE ON DELETE CASCADE
);



CREATE TABLE mitochondrial_process (
    name VARCHAR(255) NOT NULL,
    description TEXT,
    PRIMARY KEY(name)
);



CREATE TABLE pathway (
    name VARCHAR(255) NOT NULL,
    original_pathway_name VARCHAR(255) DEFAULT NULL,
    contributor TEXT NOT NULL,
    PRIMARY KEY(name),
    CONSTRAINT fk_pathway_mutation
    FOREIGN KEY(original_pathway_name)
    REFERENCES pathway(name)
    ON UPDATE CASCADE ON DELETE CASCADE
);



CREATE TABLE pathway_mitochondrial_process (
    pathway_name VARCHAR(255) NOT NULL,
    mitochondrial_process_name VARCHAR(255) NOT NULL,
    PRIMARY KEY(pathway_name, mitochondrial_process_name),
    CONSTRAINT fk_pathway_mitochondrial_process_pathway
    FOREIGN KEY(pathway_name)
    REFERENCES pathway(name)
    ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_pathway_mitochondrial_process_process
    FOREIGN KEY(mitochondrial_process_name)
    REFERENCES mitochondrial_process(name)
    ON UPDATE CASCADE ON DELETE CASCADE
);



CREATE TABLE theorem (
    pathway_name VARCHAR(255) NOT NULL,
    step INT UNSIGNED NOT NULL,
    head TEXT NOT NULL,
    body TEXT NOT NULL,
    PRIMARY KEY(pathway_name, step),
    CONSTRAINT theorem_pathway_fk
    FOREIGN KEY(pathway_name) REFERENCES pathway(name)
    ON UPDATE CASCADE ON DELETE CASCADE
);
