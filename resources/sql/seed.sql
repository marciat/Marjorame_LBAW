-----------------------------------------
---------    Drop old schema  -----------
-----------------------------------------

DROP TABLE IF EXISTS "user", "admin", buyer, photo, profile_picture, product_photo, product, product_size,
    "size", product_color, color, extra_characteristic, category, cart, address, shipping_address,
    billing_address, country, city, purchase, purchase_status, card, review, favorite, purchased_product, product_category CASCADE;

DROP TYPE IF EXISTS status_type, size_type, card_type, user_status;

DROP DOMAIN IF EXISTS before_today;

DROP FUNCTION IF EXISTS create_cart() CASCADE;
DROP FUNCTION IF EXISTS check_stock_cart() CASCADE;
DROP FUNCTION IF EXISTS update_product_stock() CASCADE;
DROP FUNCTION IF EXISTS empty_cart() CASCADE;
DROP FUNCTION IF EXISTS delete_user() CASCADE;

DROP TRIGGER IF EXISTS create_cart ON cart;
DROP TRIGGER IF EXISTS check_stock_cart ON product;
DROP TRIGGER IF EXISTS update_product_stock ON purchased_product;
DROP TRIGGER IF EXISTS empty_cart ON purchase;
DROP TRIGGER IF EXISTS delete_user ON buyer;

-------------------------------------
-----------  Types  -----------------
-------------------------------------

CREATE DOMAIN before_today AS DATE NOT NULL DEFAULT CURRENT_DATE
	constraint before_today_test CHECK(value <= CURRENT_DATE);
CREATE TYPE status_type AS ENUM ('Processing', 'Shipped', 'Delivered');
CREATE TYPE size_type AS ENUM ('XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL');
CREATE TYPE card_type AS ENUM ('Debit', 'Credit');
CREATE TYPE user_status AS ENUM ('Active', 'Banned', 'Deactivated', 'Deleted');

-----------------------------------------
------------ Tables  --------------------
-----------------------------------------

CREATE TABLE photo (
    "id" SERIAL PRIMARY KEY,
    src text NOT NULL DEFAULT 'images/default_photo.png'
);

CREATE TABLE profile_picture (
    "id" SERIAL PRIMARY KEY,
    photo_id INTEGER NOT NULL UNIQUE REFERENCES photo("id") ON UPDATE CASCADE
);

CREATE TABLE product_photo (
    "id" SERIAL PRIMARY KEY,
    photo_id INTEGER NOT NULL UNIQUE REFERENCES photo("id") ON UPDATE CASCADE
);

CREATE TABLE country (
    "id" SERIAL PRIMARY KEY,
    "name" text UNIQUE NOT NULL
);

CREATE TABLE city (
    "id" SERIAL PRIMARY KEY,
    "name" text UNIQUE NOT NULL
);

CREATE TABLE address (
    "id" SERIAL PRIMARY KEY,
    street text NOT NULL,
    additional_information text,
    residence_number  INTEGER NOT NULL CONSTRAINT positive_residence_num CHECK ((residence_number > 0)),
    zip_code text NOT NULL,
    country INTEGER NOT NULL REFERENCES country("id") ON UPDATE CASCADE,
    city INTEGER NOT NULL REFERENCES city("id") ON UPDATE CASCADE 
);

CREATE TABLE shipping_address (
    "id" SERIAL PRIMARY KEY,
    address INTEGER UNIQUE NOT NULL REFERENCES address("id") ON UPDATE CASCADE 
);

CREATE TABLE billing_address (
    "id" SERIAL PRIMARY KEY,
    address INTEGER UNIQUE NOT NULL REFERENCES address("id") ON UPDATE CASCADE 
);

CREATE TABLE "user" (
	"id" SERIAL PRIMARY KEY,
	username text UNIQUE CHECK (LENGTH(username)>2 AND LENGTH(username)<11),
	password text,
    first_name text,
    last_name text,
    email text UNIQUE,
    date_of_birth DATE CHECK (date_of_birth + 5840 * INTERVAL '1 day' <= CURRENT_DATE),
    creation_date before_today  
);
  
CREATE TABLE "admin" (
    "id" SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL UNIQUE REFERENCES "user" ("id") ON UPDATE CASCADE
);

CREATE TABLE buyer (
	"id" SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL UNIQUE REFERENCES "user" ("id") ON UPDATE CASCADE,
    status user_status NOT NULL DEFAULT 'Active',
    phone_number INTEGER UNIQUE,
    vat text,
    picture_id INTEGER UNIQUE REFERENCES profile_picture("id"),
    country_id INTEGER REFERENCES country("id"),
    shipping_address INTEGER REFERENCES shipping_address ("id") ON UPDATE CASCADE
);

CREATE TABLE category (
    "id" SERIAL PRIMARY KEY,
    category text NOT NULL
);

CREATE TABLE product_category(
    "id" SERIAL PRIMARY KEY,
    category INTEGER NOT NULL REFERENCES category ("id") ON UPDATE CASCADE,
    subcategory1 INTEGER NOT NULL REFERENCES category ("id") ON UPDATE CASCADE,
    subcategory2 INTEGER REFERENCES category ("id") ON UPDATE CASCADE
);

CREATE TABLE extra_characteristic (
    "id" SERIAL PRIMARY KEY,
    "name" text NOT NULL,
    option1 text NOT NULL,
    option2 text NOT NULL CHECK (option1 <> option2),
    option3 text CHECK (option3 <> option1 AND option3 <> option2),
    option4 text CHECK (option4 <> option1 AND option4 <> option2 AND option4 <> option3)
);

CREATE TABLE product (
    "id" SERIAL PRIMARY KEY,
    "name" text UNIQUE NOT NULL,
    description text NOT NULL,
    price FLOAT NOT NULL CHECK (price > 0),
    stock INTEGER NOT NULL CHECK (stock >=0),
    rating FLOAT CHECK (rating >= 1 AND rating <= 5),
    active text NOT NULL DEFAULT 'true',
    extra_characteristic_id INTEGER REFERENCES product("id") ON UPDATE CASCADE,
    category_id INTEGER NOT NULL REFERENCES product_category("id") ON UPDATE CASCADE,
    photo_id INTEGER NOT NULL REFERENCES product_photo("id") ON UPDATE CASCADE,
    photo2_id INTEGER REFERENCES product_photo("id") ON UPDATE CASCADE,
    photo3_id INTEGER REFERENCES product_photo("id") ON UPDATE CASCADE,
    photo4_id INTEGER REFERENCES product_photo("id") ON UPDATE CASCADE,
    photo5_id INTEGER REFERENCES product_photo("id") ON UPDATE CASCADE
);

CREATE TABLE "size" (
    "id" SERIAL PRIMARY KEY,
    "size" size_type NOT NULL 
);

CREATE TABLE product_size (
    "id" SERIAL PRIMARY KEY,
    size_id INTEGER NOT NULL REFERENCES "size"("id") ON UPDATE CASCADE,
    product_id INTEGER NOT NULL REFERENCES product("id") ON UPDATE CASCADE,
    UNIQUE (size_id, product_id)  
);

CREATE TABLE color (
    "id" SERIAL PRIMARY KEY,
    color text NOT NULL
);

CREATE TABLE product_color (
    "id" SERIAL PRIMARY KEY,
    color_id INTEGER NOT NULL REFERENCES color("id") ON UPDATE CASCADE,
    product_id INTEGER NOT NULL REFERENCES product("id") ON UPDATE CASCADE,
    UNIQUE (color_id, product_id)  
);

CREATE TABLE cart (
    "id" SERIAL PRIMARY KEY,
    quantity INTEGER NOT NULL CONSTRAINT positive_quantity CHECK ((quantity > 0)),
    buyer INTEGER NOT NULL REFERENCES buyer("id") ON UPDATE CASCADE,
    product INTEGER NOT NULL REFERENCES product("id") ON UPDATE CASCADE,  
  
  	UNIQUE (buyer, product)  
);


CREATE TABLE purchase_status (
    "id" SERIAL PRIMARY KEY,
    status status_type NOT NULL DEFAULT 'Processing'
);

CREATE TABLE card (
    "id" SERIAL PRIMARY KEY,
    "name" text NOT NULL,
    card_number TEXT NOT NULL,
  	card_type card_type NOT NULL
);

CREATE TABLE purchase (
    "id" SERIAL PRIMARY KEY,
    "date" DATE NOT NULL,
    delivery_date DATE NOT NULL CHECK (delivery_date > "date"),
    status INTEGER UNIQUE NOT NULL REFERENCES purchase_status("id") ON UPDATE CASCADE,
    card INTEGER NOT NULL REFERENCES card("id") ON UPDATE CASCADE,
    shipping_address INTEGER NOT NULL REFERENCES shipping_address("id") ON UPDATE CASCADE,
    billing_address INTEGER NOT NULL REFERENCES billing_address("id") ON UPDATE CASCADE,
    buyer INTEGER NOT NULL REFERENCES buyer("id") ON UPDATE CASCADE
);

CREATE TABLE review (
    "id" SERIAL PRIMARY KEY,
    "date" before_today NOT NULL,
    buyer INTEGER NOT NULL REFERENCES buyer("id") ON UPDATE CASCADE,
    product INTEGER NOT NULL REFERENCES product("id") ON UPDATE CASCADE,
    rating INTEGER NOT NULL CONSTRAINT correct_rating CHECK (rating >= 1 AND rating <= 5),
    title text,
    description text,
  
  	UNIQUE (buyer, product)  
);

CREATE TABLE favorite (
    "id" SERIAL PRIMARY KEY,
    buyer INTEGER NOT NULL REFERENCES buyer("id") ON UPDATE CASCADE,
    product INTEGER NOT NULL REFERENCES product("id") ON UPDATE CASCADE,
  
  	UNIQUE (buyer, product)  
);

CREATE TABLE purchased_product (
    "id" SERIAL PRIMARY KEY,
    quantity INTEGER NOT NULL CONSTRAINT positive_quantity CHECK ((quantity > 0)),
    purchase INTEGER NOT NULL REFERENCES purchase("id") ON UPDATE CASCADE,
    product INTEGER NOT NULL REFERENCES product("id") ON UPDATE CASCADE,
  
  	UNIQUE (purchase, product)  
);

-----------------------------------------
--------------  INDEXES  ----------------
-----------------------------------------
 
CREATE INDEX product_price ON product USING btree (price);

CREATE INDEX buyer_review ON review USING hash(buyer);

CREATE INDEX product_review ON review USING hash(product); 

--  FTS indexes with field weighting
CREATE INDEX search_product ON product USING GIN ((setweight(to_tsvector('english', name),'A') || setweight(to_tsvector('english', description), 'B')));

CREATE INDEX search_user ON "user" USING GIST (to_tsvector('english', first_name || ' ' || last_name)); 

-------------------------------------------
---------------  TRIGGERS  ----------------
-------------------------------------------

CREATE FUNCTION create_cart() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM cart 
        INNER JOIN product ON "cart".product = "product".id
        WHERE NEW.product = "product".id AND NEW.quantity > "product".stock ) THEN
            RAISE EXCEPTION 'Quantity not available';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE TRIGGER create_cart
    AFTER INSERT OR UPDATE ON cart
    FOR EACH ROW
    EXECUTE PROCEDURE create_cart(); 


CREATE FUNCTION check_stock_cart() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS (SELECT * FROM cart 
        INNER JOIN product ON "cart".product = "product".id
        WHERE NEW.id = "cart".product AND "cart".quantity > "product".stock ) THEN
            RAISE EXCEPTION 'Quantity not available';
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;
 
CREATE TRIGGER check_stock_cart
    AFTER UPDATE ON product
    FOR EACH ROW
    EXECUTE PROCEDURE check_stock_cart(); 
    
	
CREATE FUNCTION update_product_stock() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE product prod
    SET  stock = stock - NEW.quantity
    WHERE prod.id = NEW.product;
   	RETURN NEW; 
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER update_product_stock
    AFTER INSERT ON purchased_product
    FOR EACH ROW
    EXECUTE PROCEDURE update_product_stock(); 

CREATE FUNCTION empty_cart() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM cart c
    WHERE NEW.buyer = c.buyer;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER empty_cart
    AFTER INSERT ON purchase
    FOR EACH ROW
    EXECUTE PROCEDURE empty_cart(); 

CREATE FUNCTION delete_user() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (NEW.status = 'Deleted') 
    THEN
        UPDATE "user" u
        SET username = NULL, password = NULL, email = NULL, first_name = NULL, last_name = NULL
        WHERE NEW.user_id  = u.id;

        DELETE FROM cart c
        WHERE NEW.id = c.buyer;
        
        DELETE FROM favorite f
        WHERE NEW.id = f.buyer;
        
        DELETE FROM review r
        WHERE NEW.id = r.buyer;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER delete_user
    AFTER UPDATE OF status ON buyer
    FOR EACH ROW
    EXECUTE PROCEDURE delete_user(); 


BEGIN;

INSERT INTO photo (src) VALUES ('/images/users/uid6.jfif');
INSERT INTO photo (src) VALUES ('/images/users/uid7.jfif'),('/images/users/uid8.jfif'),('/images/users/uid9.jfif');
INSERT INTO photo (src) VALUES ('/images/users/uid10.jfif'),('/images/users/uid11.jfif'),('/images/users/uid12.jfif');
INSERT INTO photo (src) VALUES ('/images/users/uid13.jfif'),('/images/users/uid14.jfif'),('/images/users/uid15.jfif');
INSERT INTO photo (src) VALUES ('/images/users/uid16.jfif'),('/images/users/uid17.jfif'),('/images/users/uid18.jfif');
INSERT INTO photo (src) VALUES ('/images/users/uid19.jfif'),('/images/users/uid20.jfif'),('/images/users/uid21.jfif');
INSERT INTO photo (src) VALUES ('/images/users/uid22.jfif'),('/images/users/uid23.jfif'),('/images/users/uid24.jfif');
INSERT INTO photo (src) VALUES ('/images/users/uid25.jfif');
INSERT INTO photo (src) VALUES ('/images/products/pid1.png'),('/images/products/pid2.png'),('/images/products/pid3.png');
INSERT INTO photo (src) VALUES ('/images/products/pid4.png'),('/images/products/pid5.png'), ('/images/products/pid6.png');
INSERT INTO photo (src) VALUES ('/images/products/pid6-1.jpg'),('/images/products/pid6-2.jpg'),('/images/products/pid7.png'); 
INSERT INTO photo (src) VALUES ('/images/products/pid8.png'), ('/images/products/pid9.png'),('/images/products/pid10.png');
INSERT INTO photo (src) VALUES ('/images/products/pid11.png'),('/images/products/pid12.png'),('/images/products/pid13.png');
INSERT INTO photo (src) VALUES ('/images/products/pid14.png'),('/images/products/pid15.png'), ('/images/products/pid15-1.webp');
INSERT INTO photo (src) VALUES ('/images/products/pid15-2.webp'), ('/images/products/pid15-3.webp');

INSERT INTO profile_picture (photo_id) VALUES (1),(2),(3),(4),(5),(6),(7),(8),(9),(10),(11),(12),(13),(14),(15),(16),(17),(18),(19),(20);

INSERT INTO product_photo (photo_id) VALUES (21),(22),(23),(24),(25),(26),(27),(28),(29),(30),(31),(32),(33),(34),(35),(36),(37),(38),(39),(40);

INSERT INTO country ("name") VALUES ('Afghanistan');
INSERT INTO country ("name") VALUES ('Albania');
INSERT INTO country ("name") VALUES ('Algeria');
INSERT INTO country ("name") VALUES ('Andorra');
INSERT INTO country ("name") VALUES ('Angola');
INSERT INTO country ("name") VALUES ('Antigua and Barbuda');
INSERT INTO country ("name") VALUES ('Argentina');
INSERT INTO country ("name") VALUES ('Armenia');
INSERT INTO country ("name") VALUES ('Australia');
INSERT INTO country ("name") VALUES ('Austria');
INSERT INTO country ("name") VALUES ('Azerbaijan');
INSERT INTO country ("name") VALUES ('Bahamas');
INSERT INTO country ("name") VALUES ('Bahrain');
INSERT INTO country ("name") VALUES ('Bangladesh');
INSERT INTO country ("name") VALUES ('Barbados');
INSERT INTO country ("name") VALUES ('Belarus');
INSERT INTO country ("name") VALUES ('Belgium');
INSERT INTO country ("name") VALUES ('Belize');
INSERT INTO country ("name") VALUES ('Benin');
INSERT INTO country ("name") VALUES ('Bhutan');
INSERT INTO country ("name") VALUES ('Bolivia');
INSERT INTO country ("name") VALUES ('Bosnia and Herzegovina');
INSERT INTO country ("name") VALUES ('Botswana');
INSERT INTO country ("name") VALUES ('Brazil');
INSERT INTO country ("name") VALUES ('Brunei');
INSERT INTO country ("name") VALUES ('Bulgaria');
INSERT INTO country ("name") VALUES ('Burkina Faso');
INSERT INTO country ("name") VALUES ('Burundi');
INSERT INTO country ("name") VALUES ('Cambodia');
INSERT INTO country ("name") VALUES ('Cameroon');
INSERT INTO country ("name") VALUES ('Canada');
INSERT INTO country ("name") VALUES ('Cape Verde');
INSERT INTO country ("name") VALUES ('Central African Republic');
INSERT INTO country ("name") VALUES ('Chad');
INSERT INTO country ("name") VALUES ('Chile');
INSERT INTO country ("name") VALUES ('China');
INSERT INTO country ("name") VALUES ('Colombia');
INSERT INTO country ("name") VALUES ('Comoros');
INSERT INTO country ("name") VALUES ('Democratic Republic of the Congo');
INSERT INTO country ("name") VALUES ('Republic of Congo');
INSERT INTO country ("name") VALUES ('Costa Rica');
INSERT INTO country ("name") VALUES ('Cote d''Ivoire');
INSERT INTO country ("name") VALUES ('Croatia');
INSERT INTO country ("name") VALUES ('Cuba');
INSERT INTO country ("name") VALUES ('Cyprus');
INSERT INTO country ("name") VALUES ('Czech Republic');
INSERT INTO country ("name") VALUES ('Denmark');
INSERT INTO country ("name") VALUES ('Djibouti');
INSERT INTO country ("name") VALUES ('Dominica');
INSERT INTO country ("name") VALUES ('Dominican Republic');
INSERT INTO country ("name") VALUES ('Ecuador');
INSERT INTO country ("name") VALUES ('Egypt');
INSERT INTO country ("name") VALUES ('El Salvador');
INSERT INTO country ("name") VALUES ('Equatorial Guinea');
INSERT INTO country ("name") VALUES ('Eritrea');
INSERT INTO country ("name") VALUES ('Estonia');
INSERT INTO country ("name") VALUES ('Ethiopia');
INSERT INTO country ("name") VALUES ('Eswatini');
INSERT INTO country ("name") VALUES ('Fiji');
INSERT INTO country ("name") VALUES ('Finland');
INSERT INTO country ("name") VALUES ('France');
INSERT INTO country ("name") VALUES ('Gabon');
INSERT INTO country ("name") VALUES ('Gambia');
INSERT INTO country ("name") VALUES ('Georgia');
INSERT INTO country ("name") VALUES ('Germany');
INSERT INTO country ("name") VALUES ('Ghana');
INSERT INTO country ("name") VALUES ('Gibraltar');
INSERT INTO country ("name") VALUES ('Guernsey');
INSERT INTO country ("name") VALUES ('Greece');
INSERT INTO country ("name") VALUES ('Greenland');
INSERT INTO country ("name") VALUES ('Grenada');
INSERT INTO country ("name") VALUES ('Guatemala');
INSERT INTO country ("name") VALUES ('Guinea');
INSERT INTO country ("name") VALUES ('Guinea-Bissau');
INSERT INTO country ("name") VALUES ('Guyana');
INSERT INTO country ("name") VALUES ('Haiti');
INSERT INTO country ("name") VALUES ('Honduras');
INSERT INTO country ("name") VALUES ('Hong Kong');
INSERT INTO country ("name") VALUES ('Hungary');
INSERT INTO country ("name") VALUES ('Iceland');
INSERT INTO country ("name") VALUES ('India');
INSERT INTO country ("name") VALUES ('Indonesia');
INSERT INTO country ("name") VALUES ('Iran');
INSERT INTO country ("name") VALUES ('Iraq');
INSERT INTO country ("name") VALUES ('Ireland');
INSERT INTO country ("name") VALUES ('Israel');
INSERT INTO country ("name") VALUES ('Italy');
INSERT INTO country ("name") VALUES ('Jamaica');
INSERT INTO country ("name") VALUES ('Japan');
INSERT INTO country ("name") VALUES ('Jordan');
INSERT INTO country ("name") VALUES ('Kazakhstan');
INSERT INTO country ("name") VALUES ('Kenya');
INSERT INTO country ("name") VALUES ('Kiribati');
INSERT INTO country ("name") VALUES ('Kosovo');
INSERT INTO country ("name") VALUES ('Kuwait');
INSERT INTO country ("name") VALUES ('Kyrgyzstan');
INSERT INTO country ("name") VALUES ('Laos');
INSERT INTO country ("name") VALUES ('Latvia');
INSERT INTO country ("name") VALUES ('Lebanon');
INSERT INTO country ("name") VALUES ('Lesotho');
INSERT INTO country ("name") VALUES ('Liberia');
INSERT INTO country ("name") VALUES ('Libya');
INSERT INTO country ("name") VALUES ('Liechtenstein');
INSERT INTO country ("name") VALUES ('Lithuania');
INSERT INTO country ("name") VALUES ('Luxembourg');
INSERT INTO country ("name") VALUES ('Macau');
INSERT INTO country ("name") VALUES ('Madagascar');
INSERT INTO country ("name") VALUES ('Malawi');
INSERT INTO country ("name") VALUES ('Malaysia');
INSERT INTO country ("name") VALUES ('Maldives');
INSERT INTO country ("name") VALUES ('Mali');
INSERT INTO country ("name") VALUES ('Malta');
INSERT INTO country ("name") VALUES ('Marshall Islands');
INSERT INTO country ("name") VALUES ('Mauritania');
INSERT INTO country ("name") VALUES ('Mauritius');
INSERT INTO country ("name") VALUES ('Mexico');
INSERT INTO country ("name") VALUES ('Micronesia');
INSERT INTO country ("name") VALUES ('Moldova');
INSERT INTO country ("name") VALUES ('Monaco');
INSERT INTO country ("name") VALUES ('Mongolia');
INSERT INTO country ("name") VALUES ('Montenegro');
INSERT INTO country ("name") VALUES ('Morocco');
INSERT INTO country ("name") VALUES ('Mozambique');
INSERT INTO country ("name") VALUES ('Myanmar');
INSERT INTO country ("name") VALUES ('Namibia');
INSERT INTO country ("name") VALUES ('Nauru');
INSERT INTO country ("name") VALUES ('Nepal');
INSERT INTO country ("name") VALUES ('Netherlands');
INSERT INTO country ("name") VALUES ('New Zealand');
INSERT INTO country ("name") VALUES ('Nicaragua');
INSERT INTO country ("name") VALUES ('Niger');
INSERT INTO country ("name") VALUES ('Nigeria');
INSERT INTO country ("name") VALUES ('North Macedonia');
INSERT INTO country ("name") VALUES ('Norway');
INSERT INTO country ("name") VALUES ('Oman');
INSERT INTO country ("name") VALUES ('Pakistan');
INSERT INTO country ("name") VALUES ('Palau');
INSERT INTO country ("name") VALUES ('Palestine');
INSERT INTO country ("name") VALUES ('Panama');
INSERT INTO country ("name") VALUES ('Papua New Guinea');
INSERT INTO country ("name") VALUES ('Paraguay');
INSERT INTO country ("name") VALUES ('Peru');
INSERT INTO country ("name") VALUES ('Philippines');
INSERT INTO country ("name") VALUES ('Poland');
INSERT INTO country ("name") VALUES ('Portugal');
INSERT INTO country ("name") VALUES ('Puerto Rico');
INSERT INTO country ("name") VALUES ('Qatar');
INSERT INTO country ("name") VALUES ('Romania');
INSERT INTO country ("name") VALUES ('Russia');
INSERT INTO country ("name") VALUES ('Rwanda');
INSERT INTO country ("name") VALUES ('Saint Kitts and Nevis');
INSERT INTO country ("name") VALUES ('Saint Lucia');
INSERT INTO country ("name") VALUES ('Saint Vincent and the Grenadines');
INSERT INTO country ("name") VALUES ('Samoa');
INSERT INTO country ("name") VALUES ('San Marino');
INSERT INTO country ("name") VALUES ('Sao Tome and Principe');
INSERT INTO country ("name") VALUES ('Saudi Arabia');
INSERT INTO country ("name") VALUES ('Senegal');
INSERT INTO country ("name") VALUES ('Serbia');
INSERT INTO country ("name") VALUES ('Seychelles');
INSERT INTO country ("name") VALUES ('Sierra Leone');
INSERT INTO country ("name") VALUES ('Singapore');
INSERT INTO country ("name") VALUES ('Slovakia');
INSERT INTO country ("name") VALUES ('Slovenia');
INSERT INTO country ("name") VALUES ('Solomon Islands');
INSERT INTO country ("name") VALUES ('Somalia');
INSERT INTO country ("name") VALUES ('South Africa');
INSERT INTO country ("name") VALUES ('South Korea');
INSERT INTO country ("name") VALUES ('South Sudan');
INSERT INTO country ("name") VALUES ('Spain');
INSERT INTO country ("name") VALUES ('Sri Lanka');
INSERT INTO country ("name") VALUES ('Sudan');
INSERT INTO country ("name") VALUES ('Suriname');
INSERT INTO country ("name") VALUES ('Sweden');
INSERT INTO country ("name") VALUES ('Switzerland');
INSERT INTO country ("name") VALUES ('Syria');
INSERT INTO country ("name") VALUES ('Taiwan');
INSERT INTO country ("name") VALUES ('Tajikistan');
INSERT INTO country ("name") VALUES ('Tanzania');
INSERT INTO country ("name") VALUES ('Thailand');
INSERT INTO country ("name") VALUES ('Timor-Leste');
INSERT INTO country ("name") VALUES ('Togo');
INSERT INTO country ("name") VALUES ('Tonga');
INSERT INTO country ("name") VALUES ('Trinidad and Tobago');
INSERT INTO country ("name") VALUES ('Tunisia');
INSERT INTO country ("name") VALUES ('Turkey');
INSERT INTO country ("name") VALUES ('Turkmenistan');
INSERT INTO country ("name") VALUES ('Tuvalu');
INSERT INTO country ("name") VALUES ('Uganda');
INSERT INTO country ("name") VALUES ('Ukraine');
INSERT INTO country ("name") VALUES ('United Arab Emirates');
INSERT INTO country ("name") VALUES ('United Kingdom');
INSERT INTO country ("name") VALUES ('United States of America');
INSERT INTO country ("name") VALUES ('Uruguay');
INSERT INTO country ("name") VALUES ('Uzbekistan');
INSERT INTO country ("name") VALUES ('Vanuatu');
INSERT INTO country ("name") VALUES ('Venezuela');
INSERT INTO country ("name") VALUES ('Vietnam');
INSERT INTO country ("name") VALUES ('Yemen');
INSERT INTO country ("name") VALUES ('Zambia');
INSERT INTO country ("name") VALUES ('Zimbabwe');


INSERT INTO city ("name") VALUES ('Doha');
INSERT INTO city ("name") VALUES ('San José');
INSERT INTO city ("name") VALUES ('Roseau');
INSERT INTO city ("name") VALUES ('Kiev');
INSERT INTO city ("name") VALUES ('Beijing');
INSERT INTO city ("name") VALUES ('Manama');
INSERT INTO city ("name") VALUES ('London');
INSERT INTO city ("name") VALUES ('Acra');
INSERT INTO city ("name") VALUES ('Windhoek');
INSERT INTO city ("name") VALUES ('Osaka');
INSERT INTO city ("name") VALUES ('Minsk');
INSERT INTO city ("name") VALUES ('Porto');
INSERT INTO city ("name") VALUES ('Stockholm');
INSERT INTO city ("name") VALUES ('Rome');
INSERT INTO city ("name") VALUES ('Dublin');
INSERT INTO city ("name") VALUES ('Buenos Aires');
INSERT INTO city ("name") VALUES ('San Marino');
INSERT INTO city ("name") VALUES ('Luxembourg');
INSERT INTO city ("name") VALUES ('Lund');
INSERT INTO city ("name") VALUES ('Riga');


INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('Ap #558-5572 Lorem St.',133,'3654 HH',147,1);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('4614 Vitae Ave',441,'3177',41,2);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('965-4735 Primis Road',432,'29324',49,3);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('8172 Sit Avenue',627,'565606',190,4);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('P.O. Box 204, 5413 Metus. St.',945,'53859',60,5);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('Ap #155-7677 Porttitor Ave',120,'426903',13,6);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('958-763 Commodo Road',394,'81708',192,7);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('P.O. Box 758, 8035 Sed Rd.',993,'3950',66,8);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('6309 Sed Av.',668,'03326',125,9);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('6989 Sit Road',871,'618758',89,10);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('Ap #105-7464 Lectus St.',424,'221002',16,11);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('158-6875 Ac Street',598,'26804',145,12);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('8148 Mi Rd.',457,'71603',174,13);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('578 Neque Rd.',280,'71385',87,14);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('P.O. Box 661, 4663 Tortor. Av.',744,'11966',85,15);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('Ap #982-8095 Nulla Street',503,'9751',7,16);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('511-2845 Eleifend Avenue',718,'20-173',155,17);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('2478 Tempor Rd.',471,'EW03 5LB',105,18);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('Ap #874-7481 Ut, Road',917,'66053-075',174,19);
INSERT INTO address (street,residence_number,zip_code,country,city) VALUES ('P.O. Box 659, 7256 Aliquam Ave',288,'58265',98,20);

INSERT INTO shipping_address (address) VALUES (1),(2),(3),(4),(5),(6),(7),(8),(9),(10),(11),(12),(13),(14),(15),(16),(17),(18),(19),(20);

INSERT INTO billing_address (address) VALUES (1),(2),(3),(4),(5),(6),(7),(8),(9),(10),(11),(12),(13),(14),(15),(16),(17),(18),(19),(20);


INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('sol990hill','$2y$10$ouhtHJCnBqGoHuq/I3/4N.6L.khslsMfv9XwYsMEMTrNCr57w60Yy','Solene','Hill','hafayeg990@ualmail.com','03-07-1975','2020-01-21');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('jaidonhube','$2y$10$ncn8iG8P1mYmwlT0dveZ2e4r1dqCfNVED4gOqTbCrD6.o1Q95FPBG','Jaidon','Huber','vabek41984@wwrmails.com','03-07-1975','2020-01-21');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('ana_wil24','$2y$10$qH5ZXylggZDJ91.TxugHauRNa1AJMwOcNcKwyh4D.AzR9nyR4SJPq','Anabella','Wilson','hisot79663@fft-mail.com','03-07-1975','2020-01-21');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('rubysmth','$2y$10$73TM.8HD.NuHRViEqlx5T.KWViy59hMGU0/VD741QkjfVpydrbgwe','Ruby','Smith','howepi7424@ualmail.com','03-07-1975','2020-01-21');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('harry_burn','$2y$10$/kNBzOsFQ6FUCE1T/Wi/TOc4qwH7IxuBQPFY8N9OOfxkvkSKbDFoW','Harry','Burn','fagid79852@fft-mail.com','03-07-1975','2020-01-21');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('coff_jeff','$2y$10$USiFBl/rnjv2OBZ3bne4bujnsjnsO5CJLc4HqkIc4avrk96ufk1Pu','Jeff','Coffey','jewil57762@mailboxt.com','01-07-1960','2020-01-24');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('nellyyy89','$2y$10$6kyCoim7QZHrUyIzItb2s.ooe6SfnQ.lBM/oTMXZeGPi.BwcXeJaW','Nelly','Tran','foyajeb881@mailboxt.com','03-07-1975','2020-01-25');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('kknhouse','$2y$10$1HI7sXCqNnXzImOqvvActeUuXeVFlDvG2ZvqSJE2c0xaXg3Ak1HnG','Kaine','House','repay42209@mailmyrss.com','03-12-1949','2020-01-25');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('k48michael','$2y$10$erediFtmoL3rELfWy1grjO7D6v/SKP7qzKcTKMHuhfM5z5MJTyO3m','Kia','Michael','nejix70548@wwrmails.com','10-04-1993','2020-01-25');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('frankieee','$2y$10$2/jCMCu.3wyDh0vYrnUWAes8c0CHOia6W.2yKlBqlk7wcbF2H.2Au','Dave','Franks','nijak88952@itiomail.com','12-11-1975','2020-01-31');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('jr217362','$2y$10$.5tIekHPei56xzrEQcwzIuZiSGDU/4kgr79itF19EWWYeflVCFHiq','Junior','Sadler','socey89342@gotkmail.com','02-09-1944','2020-02-20');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('kurbees1','$2y$10$pDSZdJTavMS6R7a3lyebqu65c7mGHIG8j7TCCGCBWq.Ghqy0J0ILW','Isabel','Murillo','marciat@example.com','12-08-1979','2020-02-21');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('m347orris','$2y$10$MFiYhVkzqblx8DWBChC7UOUBNvtD7XArUNllEg0IGwD5onp.tqM5q','Nyla','Morris','idabifon-8088@yopmail.com','04-08-1986','2020-02-21');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('lisaajjn','$2y$10$EIIItGJ5n9rP.XPFmSrIuuITtsNZ1nmwyL45Ew4Adv6SYUANrI1iG','Lisa', 'Johnson','socppy8932@gotkmail.com','06-05-1986','2020-02-21');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('weeest67','$2y$10$UyjdpPiDvHCE.IOuF4yG8eOCdkHs2QeyUl8SO2UgxDIP65u5hrv1u','Wesley','Short','matab17451@gotkmail.com','12-14-1980','2020-02-22');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('yoc360eye','$2y$10$0Wy8IZA/v7RaIs5OYqbsHejooL0glRtE9TxdPYSpKxMO.yXZIm5ai','Elsa','Howe','yoceye3360@mailboxt.com','02-22-1985','2020-03-01');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('heroki1021','$2y$10$ReKFXt/uyTt4o14OxVmQ5OJACJrmkNlhSiQMhUZjQJg26qM.Rde72','Jeremy','Carter','heroki1021@gotkmail.com','10-31-1995','2020-03-04');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('iris12cope','$2y$10$Dd.mMAUXTVWavSB14gXIm.Y3l/1/TmMZ7LMizFD8iHdLWccCDrM8K','Iris','Cope','poger18627@svpmail.com','05-03-1957','2020-03-05');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('victor65jo','$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W','Victor','Wharton','john@example.com','03-28-1998','2020-03-05');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('kristixef','$2y$10$h1o97qQ8dMeiPLOzXBOsmOV/vJ2pHT6crU0aWSsIFQ6yBqDKiMXHW','Kristi','Page','xeraxef525@gotkmail.com','06-21-1988','2020-03-28');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('vevomacie','$2y$10$TvK6JlF6XjzmQgEUQnV3NO1XcbZQeKQ.Duvp9ZyeG3KPXsdBe.jJm','Macie','Khan','vevoma2869@mailboxt.com','12-20-1993','2020-03-28');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('jonlofi','$2y$10$HN9KGjAsXCvNFLll2SSVdefoAouh5qSbOG4DYxkdg5NUV3tFVauFq','Jon','Douglas','lofimo8426@wwrmails.com','01-30-1990','2020-03-28');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('darla_ch','$2y$10$zuqPwlNFFgdNTwQjxfqNzO4oVV2bvtgZh9/c2J69KEm/x7zjNGu.2','Darla','Church','pohix11319@mailmyrss.com','12-09-1986','2020-04-01');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('olsenjames','$2y$10$OxTB57iAyfLG6P9p2NW8..F0GzMDoo5TUN1JZlw6cu4zvxWMjcNTa','James','Olsen','lesovo6358@svpmail.com','06-24-1994','2020-04-02');
INSERT INTO "user" (username, password, first_name, last_name, email, date_of_birth, creation_date) VALUES ('m58423east','$2y$10$LaM3nrfpPc8FH.yr0ULcxuTs410Rc0JMp92PS18aVwjpcUQLBp/zO','Maya','East','waviy58423@ualmail.com','03-17-1990','2020-04-02');

INSERT INTO "admin" (user_id) VALUES (1);
INSERT INTO "admin" (user_id) VALUES (2);
INSERT INTO "admin" (user_id) VALUES (3);
INSERT INTO "admin" (user_id) VALUES (4);
INSERT INTO "admin" (user_id) VALUES (5);

INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (6,'Active','896075124','166107074871',1,147,1);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (7,'Active','990914871','160909016503',2,41,2);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (8,'Active','315910778','163804136772',3,49,3);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (9,'Active','936564298','165909101916',4,190,4);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (10,'Active','828256166','161302261241',5,60,5);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (11,'Active','134828237','164008219398',6,13,6);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (12,'Active','358631082','164305147532',7,128,7);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (13,'Active','143802689','160008054934',8,66,8);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (14,'Banned','480338681','166512116358',9,125,9);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (15,'Active','436428435','160511249658',10,89,10);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (16,'Active','656777809','162409232010',11,16,11);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (17,'Active','330658534','162508021355',12,145,12);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (18,'Deleted','293388339','169203141859',13,174,13);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (19,'Active','742938238','165302013551',14,87,14);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (20,'Active','543940947','16880517 8004',15,85,15);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (21,'Active','300301857','160605011238',16,7,16);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (22,'Active','933065528','166804095336',17,155,17);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (23,'Active','848274276','164108278351',18,105,18);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (24,'Active','247148009','169302236428',19,174,19);
INSERT INTO buyer (user_id, status, phone_number, vat, picture_id, country_id, shipping_address) VALUES (25,'Active','954883386','169609143889',20,98,20);

INSERT INTO category (category) VALUES ('Fashion');
INSERT INTO category (category) VALUES ('Winter Accessories');
INSERT INTO category (category) VALUES ('Beanies');
INSERT INTO category (category) VALUES ('Scarves');
INSERT INTO category (category) VALUES ('Gloves');
INSERT INTO category (category) VALUES ('Watches');
INSERT INTO category (category) VALUES ('Jewelry');
INSERT INTO category (category) VALUES ('Earrings');
INSERT INTO category (category) VALUES ('Necklaces');
INSERT INTO category (category) VALUES ('Rings');
INSERT INTO category (category) VALUES ('Bracelets');
INSERT INTO category (category) VALUES ('Belts');
INSERT INTO category (category) VALUES ('Bags and Wallets');
INSERT INTO category (category) VALUES ('Wallets');
INSERT INTO category (category) VALUES ('Backpacks');
INSERT INTO category (category) VALUES ('Tote Bags');
INSERT INTO category (category) VALUES ('Shoulder Bags');
INSERT INTO category (category) VALUES ('Socks');
INSERT INTO category (category) VALUES ('Clothing');
INSERT INTO category (category) VALUES ('Tops');
INSERT INTO category (category) VALUES ('Bottoms');
INSERT INTO category (category) VALUES ('Beauty');
INSERT INTO category (category) VALUES ('Hygiene');
INSERT INTO category (category) VALUES ('Makeup');
INSERT INTO category (category) VALUES ('Fragrances');
INSERT INTO category (category) VALUES ('Lips');
INSERT INTO category (category) VALUES ('Eyes');
INSERT INTO category (category) VALUES ('Face');
INSERT INTO category (category) VALUES ('Accessories');
INSERT INTO category (category) VALUES ('Decor');
INSERT INTO category (category) VALUES ('Bathroom');
INSERT INTO category (category) VALUES ('Bedroom');
INSERT INTO category (category) VALUES ('Living Room');
INSERT INTO category (category) VALUES ('Kitchen');
INSERT INTO category (category) VALUES ('Outdoors');

INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,2,3);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,2,4);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,2,5);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,6,NULL);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,7,8);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,7,9);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,7,10);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,7,11);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,12,NULL);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,13,14);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,13,15);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,13,16);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,13,17);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,18,NULL);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,19,20);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (1,19,21);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (22,23,NULL);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (22,25,NULL);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (22,24,26);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (22,24,27);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (22,24,28);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (22,24,29);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (30,31,NULL);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (30,32,NULL);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (30,33,NULL);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (30,34,NULL);
INSERT INTO product_category(category, subcategory1, subcategory2) VALUES (30,35,NULL);


INSERT INTO extra_characteristic ("name", option1, option2, option3, option4) VALUES ('Aroma', 'Chai Tea', 'Lavender', 'Sweet Orange', NULL);

INSERT INTO size("size") VALUES ('XS');
INSERT INTO size("size") VALUES ('S');
INSERT INTO size("size") VALUES ('M');
INSERT INTO size("size") VALUES ('L');
INSERT INTO size("size") VALUES ('XL');
INSERT INTO size("size") VALUES ('XXL');
INSERT INTO size("size") VALUES ('XXS');

INSERT INTO color(color) VALUES ('Black');
INSERT INTO color(color) VALUES ('White');
INSERT INTO color(color) VALUES ('Blue');
INSERT INTO color(color) VALUES ('Pink');
INSERT INTO color(color) VALUES ('Purple');
INSERT INTO color(color) VALUES ('Red');
INSERT INTO color(color) VALUES ('Orange');
INSERT INTO color(color) VALUES ('Yellow');
INSERT INTO color(color) VALUES ('Green');
INSERT INTO color(color) VALUES ('Brown');

INSERT INTO product ("name", description, price, stock, rating, active, extra_characteristic_id, category_id, photo_id, photo2_id, photo3_id, photo4_id, photo5_id)
    VALUES ('Beige Knitted Sweater','Hand knitted warm sweater', 20.99, 500, 4.0, 'true', NULL, 15, 1, NULL, NULL, NULL, NULL),
    ('Faux Leather Wallet', 'Sleek and classic wallet, made with durable, high quality, faux leather', 10.99, 300, 4.5, 'true', NULL, 10, 2, NULL, NULL, NULL, NULL),
    ('Golden Hoop Shell Earrings', 'Glamourous earrings for a summery touch', 6.99, 500, 2.3, 'true', NULL, 5, 3, NULL, NULL, NULL, NULL),
    ('Multicolored Striped Socks', 'Warm multicolored socks', 6.99, 400, 5.0, 'true', NULL, 14, 4, NULL, NULL, NULL, NULL),
    ('Faux Leather Watch', 'Classy durable watch', 25.99, 500, 4.0, 'true', NULL, 4, 5, NULL, NULL, NULL, NULL),
    ('Handcrafted Natural Soap', 'Handcrafted vegan soap for sensitive skin', 5.99, 200, 4.5, 'true', 1, 17, 6, 7, 8, NULL, NULL),
    ('EcoPanda Cotton Pads', 'Soft 100% bio and ethical cotton pads', 4.99, 500, 4.0, 'true', NULL, 22, 9, NULL, NULL, NULL, NULL),
    ('Peppermint Bath Bomb', 'For a refreshing and energizing bath', 3.99, 400, 2.8, 'false', NULL, 17, 10, NULL, NULL, NULL, NULL),
    ('Therapeutic Skin Balm', 'Moisturizer for sensitive skin', 15.99, 500, 4.0, 'true', NULL, 17, 11, NULL, NULL, NULL, NULL),
    ('Long-lasting Matte Lipstick', 'Moisturizing, lasts up to 12 hours', 15.99, 500, 3.0, 'true', NULL, 19, 12, NULL, NULL, NULL, NULL),
    ('Soap Dispenser', 'Handmade, each piece is an unique work', 34.99, 500, 4.0, 'true', NULL, 23, 13, NULL, NULL, NULL, NULL),
    ('Wooden Spoon (3-Pack)', 'Heat resistant and safe for food preparation', 15.99, 100, 5.0, 'true', NULL, 26, 14, NULL, NULL, NULL, NULL),
    ('Knitted Blanket', 'Soft 100% cotton hand knitted blanket', 79.99, 100, 4.0, 'true', NULL, 24, 15, NULL, NULL, NULL, NULL),
    ('Garden Gnome', 'Hand painted, each piece is an unique work', 30.99, 100, 5.0, 'true', NULL, 27, 16, NULL, NULL, NULL, NULL),
    ('Force Majeure T-Shirt', '100% bio cotton, unisex',15.99, 500, 4.0, 'true', NULL, 15, 17, 18, 19, 20, NULL);


INSERT INTO product_size (size_id, product_id) VALUES (2, 1);
INSERT INTO product_size (size_id, product_id) VALUES (3, 1);
INSERT INTO product_size (size_id, product_id) VALUES (4, 1);
INSERT INTO product_size (size_id, product_id) VALUES (2, 15);
INSERT INTO product_size (size_id, product_id) VALUES (3, 15);
INSERT INTO product_size (size_id, product_id) VALUES (4, 15);
INSERT INTO product_size (size_id, product_id) VALUES (5, 15);
INSERT INTO product_size (size_id, product_id) VALUES (6, 15);

INSERT INTO product_color (color_id, product_id) VALUES (4, 10);
INSERT INTO product_color (color_id, product_id) VALUES (5, 10);
INSERT INTO product_color (color_id, product_id) VALUES (6, 10);
INSERT INTO product_color (color_id, product_id) VALUES (7, 10);

INSERT INTO favorite (buyer, product) VALUES (6,2);
INSERT INTO favorite (buyer, product) VALUES (6,3);
INSERT INTO favorite (buyer, product) VALUES (6,6);
INSERT INTO favorite (buyer, product) VALUES (10,6);
INSERT INTO favorite (buyer, product) VALUES (10,4);
INSERT INTO favorite (buyer, product) VALUES (10,3);
INSERT INTO favorite (buyer, product) VALUES (10,1);
INSERT INTO favorite (buyer, product) VALUES (7,1);
INSERT INTO favorite (buyer, product) VALUES (7,7);
INSERT INTO favorite (buyer, product) VALUES (8,10);
INSERT INTO favorite (buyer, product) VALUES (8,11);
INSERT INTO favorite (buyer, product) VALUES (20,3);
INSERT INTO favorite (buyer, product) VALUES (20,14);
INSERT INTO favorite (buyer, product) VALUES (15,4);
INSERT INTO favorite (buyer, product) VALUES (15,7);
INSERT INTO favorite (buyer, product) VALUES (15,3);
INSERT INTO favorite (buyer, product) VALUES (20,5);
INSERT INTO favorite (buyer, product) VALUES (20,15);
INSERT INTO favorite (buyer, product) VALUES (13,3);
INSERT INTO favorite (buyer, product) VALUES (13,2);
INSERT INTO favorite (buyer, product) VALUES (13,5);
INSERT INTO favorite (buyer, product) VALUES (19,3);
INSERT INTO favorite (buyer, product) VALUES (19,9);
INSERT INTO favorite (buyer, product) VALUES (19,10);
INSERT INTO favorite (buyer, product) VALUES (12,1);

INSERT INTO cart (quantity, buyer, product) VALUES (2,7,2);
INSERT INTO cart (quantity, buyer, product) VALUES (3,7,3);
INSERT INTO cart (quantity, buyer, product) VALUES (1,7,6);
INSERT INTO cart (quantity, buyer, product) VALUES (1,10,6);
INSERT INTO cart (quantity, buyer, product) VALUES (1,10,4);
INSERT INTO cart (quantity, buyer, product) VALUES (4,10,3);
INSERT INTO cart (quantity, buyer, product) VALUES (1,10,1);
INSERT INTO cart (quantity, buyer, product) VALUES (2,7,1);
INSERT INTO cart (quantity, buyer, product) VALUES (1,7,7);
INSERT INTO cart (quantity, buyer, product) VALUES (1,8,10);
INSERT INTO cart (quantity, buyer, product) VALUES (4,8,11);
INSERT INTO cart (quantity, buyer, product) VALUES (5,20,3);
INSERT INTO cart (quantity, buyer, product) VALUES (6,20,14);
INSERT INTO cart (quantity, buyer, product) VALUES (3,2,4);
INSERT INTO cart (quantity, buyer, product) VALUES (2,2,7);
INSERT INTO cart (quantity, buyer, product) VALUES (2,2,3);
INSERT INTO cart (quantity, buyer, product) VALUES (1,2,5);
INSERT INTO cart (quantity, buyer, product) VALUES (6,2,15);
INSERT INTO cart (quantity, buyer, product) VALUES (1,13,3);
INSERT INTO cart (quantity, buyer, product) VALUES (6,13,2);
INSERT INTO cart (quantity, buyer, product) VALUES (10,13,5);
INSERT INTO cart (quantity, buyer, product) VALUES (1,19,3);
INSERT INTO cart (quantity, buyer, product) VALUES (5,12,9);
INSERT INTO cart (quantity, buyer, product) VALUES (1,12,10);
INSERT INTO cart (quantity, buyer, product) VALUES (10,12,1);

INSERT INTO review ("date", buyer, product, rating, title, description) VALUES ('03-20-2020',6,2,5, 'Great Product!', 'I really loved it <3');
INSERT INTO review ("date", buyer, product, rating, title, description) VALUES ('03-21-2020',6,3,4, NULL, NULL);
INSERT INTO review ("date", buyer, product, rating, title, description) VALUES ('03-23-2020',6,6,4, NULL, NULL);
INSERT INTO review ("date", buyer, product, rating, title, description) VALUES ('03-25-2020',10,6,4, 'So good!!!', 'Thank you very much for this!');
INSERT INTO review ("date", buyer, product, rating, title, description) VALUES ('03-25-2020',10,4,5, NULL, NULL);

INSERT INTO purchase_status (status) VALUES ('Delivered'); 
INSERT INTO purchase_status (status) VALUES ('Delivered');
INSERT INTO purchase_status (status) VALUES ('Delivered');
INSERT INTO purchase_status (status) VALUES ('Delivered');
INSERT INTO purchase_status (status) VALUES ('Shipped');

INSERT INTO card ("name", card_number, card_type) VALUES ('mario123',123321123,'Debit'); 
INSERT INTO card ("name", card_number, card_type) VALUES ('miguel rocha',135235623,'Credit'); 
INSERT INTO card ("name", card_number, card_type) VALUES ('maria maria',134654123,'Debit'); 
INSERT INTO card ("name", card_number, card_type) VALUES ('new clothes',123234623,'Debit'); 
INSERT INTO card ("name", card_number, card_type) VALUES ('carddddd',123454352,'Credit'); 

INSERT INTO purchase ("date", delivery_date, status, card, shipping_address, billing_address, buyer) VALUES ('03-20-2020','03-29-2020',1,1,1,1,6); 
INSERT INTO purchase ("date", delivery_date, status, card, shipping_address, billing_address, buyer) VALUES ('03-22-2020','04-02-2020',2,2,2,2,8);
INSERT INTO purchase ("date", delivery_date, status, card, shipping_address, billing_address, buyer) VALUES ('03-22-2020','04-01-2020',3,3,3,3,9);
INSERT INTO purchase ("date", delivery_date, status, card, shipping_address, billing_address, buyer) VALUES ('03-25-2020','04-10-2020',4,4,4,4,10);
INSERT INTO purchase ("date", delivery_date, status, card, shipping_address, billing_address, buyer) VALUES ('03-30-2020','04-07-2020',5,5,5,5,17);

INSERT INTO purchased_product (quantity, purchase, product) VALUES (1,1,2); 
INSERT INTO purchased_product (quantity, purchase, product) VALUES (1,1,3);
INSERT INTO purchased_product (quantity, purchase, product) VALUES (2,1,6);
INSERT INTO purchased_product (quantity, purchase, product) VALUES (1,2,8);
INSERT INTO purchased_product (quantity, purchase, product) VALUES (2,3,9);
INSERT INTO purchased_product (quantity, purchase, product) VALUES (1,4,6);
INSERT INTO purchased_product (quantity, purchase, product) VALUES (1,4,4);
INSERT INTO purchased_product (quantity, purchase, product) VALUES (2,5,15);

COMMIT;
