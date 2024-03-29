PRAGMA foreign_keys=on;

DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS Sizes;
DROP TABLE IF EXISTS Conditions;
DROP TABLE IF EXISTS Items;
DROP TABLE IF EXISTS Carts;
DROP TABLE IF EXISTS Chats;
DROP TABLE IF EXISTS Orders;

DROP TRIGGER IF EXISTS UpdateItemStatusAfterOrder;
DROP TRIGGER IF EXISTS ReactivateItemOnOrderCancel;


CREATE TABLE Users (
    idUser INTEGER PRIMARY KEY,
    name TEXT NOT NULL,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL
);

CREATE TABLE Categories (
    idCategory INTEGER PRIMARY KEY,
    categoryName TEXT UNIQUE NOT NULL
);

CREATE TABLE Sizes (
    idSize INTEGER PRIMARY KEY,
    sizeName TEXT UNIQUE NOT NULL
);

CREATE TABLE Conditions (
    idCondition INTEGER PRIMARY KEY,
    conditionName TEXT UNIQUE NOT NULL
);

CREATE TABLE Items (
    idItem INTEGER PRIMARY KEY,
    idSeller INTEGER NOT NULL,
    name TEXT NOT NULL,
    introduction TEXT,
    description TEXT,
    idCategory TEXT,
    brand TEXT,
    model TEXT,
    idSize TEXT,
    idCondition TEXT,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    --falta imagem
    FOREIGN KEY (idSeller) REFERENCES Users(idUser),
    FOREIGN KEY (idCategory) REFERENCES Categories(idCategory),
    FOREIGN KEY (idSize) REFERENCES Sizes(idSize),
    FOREIGN KEY (idCondition) REFERENCES Conditions(idCondition)
);

CREATE TABLE Carts (
    idCart INTEGER PRIMARY KEY,
    idUser INTEGER NOT NULL,
    idItem INTEGER NOT NULL,
    quantity INTEGER DEFAULT 1,
    FOREIGN KEY (idUser) REFERENCES Users(idUser),
    FOREIGN KEY (idItem) REFERENCES Items(idItem)
);

CREATE TABLE Chats (
    idChat INTEGER PRIMARY KEY,
    idSender INTEGER NOT NULL,
    idRecipient INTEGER NOT NULL,
    message TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idSender) REFERENCES Users(idUser),
    FOREIGN KEY (idRecipient) REFERENCES Users(idUser)
);

CREATE TABLE Orders (
    idOrder INTEGER PRIMARY KEY,
    idBuyer INTEGER NOT NULL,
    idItem INTEGER NOT NULL,
    quantity INTEGER DEFAULT 1,
    totalPrice REAL NOT NULL,
    orderDate TEXT DEFAULT CURRENT_TIMESTAMP,
    status TEXT NOT NULL DEFAULT 'Pending',
    CONSTRAINT CHECK_Status CHECK (status = 'Pending' OR  status='Done' OR  status='Canceled'),
    FOREIGN KEY (idBuyer) REFERENCES Users(idUser),
    FOREIGN KEY (idItem) REFERENCES Items(idItem)
);


CREATE TRIGGER UpdateItemStatusAfterOrder
AFTER INSERT ON Orders
BEGIN
    UPDATE Items
    SET active = FALSE
    WHERE idItem = NEW.idItem;
END;

CREATE TRIGGER ReactivateItemOnOrderCancel
AFTER UPDATE OF status ON Orders
WHEN NEW.status = 'Canceled'
BEGIN
    UPDATE Items
    SET active = TRUE
    WHERE idItem = NEW.idItem;
END;




INSERT INTO Users (name, username, password, email) VALUES
('Leonardo Teixeira', 'leo', '12345678', 'leo@gmail.com'),
('Cristiano Ronaldo', 'paicris', '12345678', 'cr7@gmail.com'),
('Neymar Jr', 'neymito', '12345678', 'ney@gmail.com');

INSERT INTO Categories (categoryName) VALUES
('Electronics'),
('Clothing'),
('Furniture'),
('Books'),
('Games'),
('Sports'),
('Homeware'),
('Others');

INSERT INTO Sizes (sizeName) VALUES
('Small'),
('Medium'),
('Large');

INSERT INTO Conditions (conditionName) VALUES
('New'),
('Used');

INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition)
VALUES (1, 'Smartphone', 'gently used smartphone', 'A gently used smartphone in excellent condition. Comes with charger and original packaging.', 1, 'Samsung', 'Galaxy S10', 1, 2);
INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition)
VALUES (1, 'Bicycle', 'nice bicycle', 'A sturdy bicycle perfect for commuting or leisure rides. Includes a basket for carrying items.', 6, 'Schwinn', 'Cruiser', 3, 2);
INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition)
VALUES (1, 'Laptop', 'powerful laptop', 'A powerful laptop suitable for work and entertainment. Features a fast processor and ample storage.', 1, 'Dell', 'XPS 15', 2, 1);
INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition)
VALUES (1, 'Elegant Dress', 'elegant dress', 'An elegant dress perfect for formal occasions or evening events. Made from high-quality fabric with exquisite design details.', 2, 'Ralph Lauren', 'Elegant Evening Gown', 2, 1);
INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition)
VALUES (1, 'Stylish Shoes', 'nice shoes', 'A pair of stylish and comfortable shoes suitable for everyday wear. Features durable material and a sleek design.', 2, 'Nike', 'Air Max', 1, 1);

INSERT INTO Carts (idUser, idItem, quantity) VALUES
(2, 1, 2),
(2, 2, 1);

INSERT INTO Chats (idSender, idRecipient, message) VALUES
(2, 1, 'Hello come to al-nassr!'),
(1, 2, 'Sure! What specific details would you like to know?');

INSERT INTO Orders (idBuyer, idItem, quantity, totalPrice) VALUES
(2, 1, 1, 200.00),
(2, 2, 2, 800.00);