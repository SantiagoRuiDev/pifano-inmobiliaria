-- Created by Redgate Data Modeler
-- Cleaned & standardized for MySQL

-- ============================
-- TABLE: Client
-- ============================
CREATE TABLE Client (
    id_client INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    lastname VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    address VARCHAR(150) NOT NULL,
    dni INT NOT NULL,
    CONSTRAINT Client_pk PRIMARY KEY (id_client)
);

-- ============================
-- TABLE: Technical_properties
-- ============================
CREATE TABLE Technical_properties (
    id_technical_properties INT NOT NULL AUTO_INCREMENT,
    cadastral_nomenclature VARCHAR(150) NOT NULL,
    departure_number INT NOT NULL,
    topography VARCHAR(100) NOT NULL,
    parcel INT NOT NULL,
    meters_front DECIMAL(10,2) NOT NULL,
    meters_deep DECIMAL(10,2) NOT NULL,
    access VARCHAR(100) NOT NULL,
    services TEXT NOT NULL,
    busy BOOLEAN NOT NULL,
    surface VARCHAR(150) NOT NULL,
    amenities TEXT NOT NULL,
    adjustment_type VARCHAR(100) NOT NULL,
    is_new BOOLEAN NOT NULL,
    CONSTRAINT Technical_properties_pk PRIMARY KEY (id_technical_properties)
);

-- ============================
-- TABLE: Property
-- ============================
CREATE TABLE Property (
    id_property INT NOT NULL AUTO_INCREMENT,
    city VARCHAR(150) NOT NULL,
    country VARCHAR(150) NOT NULL,
    address VARCHAR(150) NOT NULL,
    floor INT NOT NULL,
    apartment INT NOT NULL,
    description VARCHAR(150) NOT NULL,
    type VARCHAR(100) NOT NULL,
    base_price INT NOT NULL,
    id_technical_properties INT NOT NULL,
    CONSTRAINT Property_pk PRIMARY KEY (id_property),
    CONSTRAINT Property_Technical_properties FOREIGN KEY (id_technical_properties)
        REFERENCES Technical_properties (id_technical_properties)
);

-- ============================
-- TABLE: Rent
-- ============================
CREATE TABLE Rent (
    id_rent INT NOT NULL AUTO_INCREMENT,
    amount INT NOT NULL,
    honorarium INT NOT NULL,
    discount INT NOT NULL,
    generation_date DATE NOT NULL,
    payment_method VARCHAR(150) NOT NULL,
    id_locator INT NOT NULL,
    id_property INT NOT NULL,
    id_tenant INT NOT NULL,
    id_guarantor INT NOT NULL,
    adjustment_type VARCHAR(100) NOT NULL,
    adjustment_time DATE NOT NULL,
    start_contract DATE NOT NULL,
    end_contract DATE NOT NULL,
    CONSTRAINT Rent_pk PRIMARY KEY (id_rent),
    
    CONSTRAINT Rent_Locator FOREIGN KEY (id_locator)
        REFERENCES Client (id_client),
    CONSTRAINT Rent_Tenant FOREIGN KEY (id_tenant)
        REFERENCES Client (id_client),
    CONSTRAINT Rent_Guarantor FOREIGN KEY (id_guarantor)
        REFERENCES Client (id_client),
    CONSTRAINT Rent_Property FOREIGN KEY (id_property)
        REFERENCES Property (id_property)
);
