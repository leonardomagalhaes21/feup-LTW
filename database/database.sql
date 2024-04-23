PRAGMA foreign_keys=on;

.headers on
.mode columns
.nullvalue NULL

DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS Sizes;
DROP TABLE IF EXISTS Conditions;
DROP TABLE IF EXISTS Items;
DROP TABLE IF EXISTS Images;
DROP TABLE IF EXISTS Chats;
DROP TABLE IF EXISTS Orders;
DROP TABLE IF EXISTS OrderItems;
DROP TABLE IF EXISTS Wishlists;

DROP TRIGGER IF EXISTS UpdateItemStatusAfterOrder;
DROP TRIGGER IF EXISTS ReactivateItemOnOrderCancel;


CREATE TABLE Users (
    idUser INTEGER PRIMARY KEY,
    name TEXT NOT NULL,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    isAdmin BOOLEAN NOT NULL DEFAULT 0
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
    idItem INTEGER PRIMARY KEY AUTOINCREMENT,
    idSeller INTEGER NOT NULL,
    name TEXT NOT NULL,
    introduction TEXT,
    description TEXT,
    idCategory INTEGER,
    brand TEXT,
    model TEXT,
    idSize INTEGER,
    idCondition INTEGER,
    price REAL NOT NULL,
    active BOOLEAN NOT NULL DEFAULT TRUE,
    FOREIGN KEY (idSeller) REFERENCES Users(idUser),
    FOREIGN KEY (idCategory) REFERENCES Categories(idCategory),
    FOREIGN KEY (idSize) REFERENCES Sizes(idSize),
    FOREIGN KEY (idCondition) REFERENCES Conditions(idCondition)
);

CREATE TABLE Images (
    idImage INTEGER PRIMARY KEY AUTOINCREMENT,
    imagePath TEXT NOT NULL
);

CREATE TABLE ItemImages (
    idItemImage INTEGER PRIMARY KEY AUTOINCREMENT,
    idItem INTEGER NOT NULL,
    idImage INTEGER NOT NULL,
    isMain BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (idItem) REFERENCES Items(idItem),
    FOREIGN KEY (idImage) REFERENCES Images(idImage)
);

CREATE TABLE UserImage (
    idUserImage INTEGER PRIMARY KEY AUTOINCREMENT,
    idUser INTEGER NOT NULL,
    idImage INTEGER NOT NULL,
    FOREIGN KEY (idUser) REFERENCES Users(idUser),
    FOREIGN KEY (idImage) REFERENCES Images(idImage)
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
    totalPrice REAL NOT NULL,
    orderDate TEXT DEFAULT CURRENT_TIMESTAMP,
    status TEXT NOT NULL DEFAULT 'Pending',
    CONSTRAINT CHECK_Status CHECK (status = 'Pending' OR status='Done' OR status='Canceled'),
    FOREIGN KEY (idBuyer) REFERENCES Users(idUser)
);

CREATE TABLE OrderItems (
    idOrderItem INTEGER PRIMARY KEY,
    idOrder INTEGER NOT NULL,
    idItem INTEGER NOT NULL,
    FOREIGN KEY (idOrder) REFERENCES Orders(idOrder),
    FOREIGN KEY (idItem) REFERENCES Items(idItem)
);

CREATE TABLE Wishlists (
    idWishlist INTEGER PRIMARY KEY,
    idUser INTEGER NOT NULL,
    idItem INTEGER NOT NULL,
    FOREIGN KEY (idUser) REFERENCES Users(idUser),
    FOREIGN KEY (idItem) REFERENCES Items(idItem)
);


CREATE TRIGGER UpdateItemStatusAfterOrder
AFTER INSERT ON OrderItems
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
    WHERE idItem = (SELECT idItem FROM OrderItems WHERE idOrder = NEW.idOrder);
END;





INSERT INTO Users (name, username, password, email, isAdmin) VALUES
('Leonardo Teixeira', 'leo', '$2y$10$4zN2fHMbSNK1tI82oS8JBeoFRJ6PNUPe6E6ZpUswZr5remJUk/0hu', 'leo@gmail.com', 1),
('Cristiano Ronaldo', 'paicris', '$2y$10$4zN2fHMbSNK1tI82oS8JBeoFRJ6PNUPe6E6ZpUswZr5remJUk/0hu', 'cr7@gmail.com', 1),
('Neymar Jr', 'neymito', '$2y$10$4zN2fHMbSNK1tI82oS8JBeoFRJ6PNUPe6E6ZpUswZr5remJUk/0hu', 'ney@gmail.com', 0);

INSERT INTO Categories (categoryName) VALUES
('&#128187; Electronics'),
('&#128084; Clothing'),
('&#129681; Furniture'),
('&#128218; Books'),
('&#127918; Games'),
('&#9917; Sports'),
('&#128250; Homeware'),
('&#128259; Others');

INSERT INTO Sizes (sizeName) VALUES
('Small'),
('Medium'),
('Large');

INSERT INTO Conditions (conditionName) VALUES
('New'),
('Used');

INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition, price)
VALUES (1, 'Smartphone', 'gently used smartphone', 'A gently used smartphone in excellent condition. Comes with charger and original packaging.', 1, 'Samsung', 'Galaxy S10', 1, 2, 200);
INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition, price)
VALUES (1, 'Bicycle', 'nice bicycle', 'A sturdy bicycle perfect for commuting or leisure rides. Includes a basket for carrying items.', 6, 'Schwinn', 'Cruiser', 3, 2, 150);
INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition, price)
VALUES (1, 'Laptop', 'powerful laptop', 'A powerful laptop suitable for work and entertainment. Features a fast processor and ample storage.', 1, 'Dell', 'XPS 15', 2, 1, 800);
INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition, price)
VALUES (1, 'Elegant Dress', 'elegant dress', 'An elegant dress perfect for formal occasions or evening events. Made from high-quality fabric with exquisite design details.', 2, 'Ralph Lauren', 'Elegant Evening Gown', 2, 1, 120);
INSERT INTO Items (idSeller, name, introduction, description, idCategory, brand, model, idSize, idCondition, price)
VALUES (1, 'Stylish Shoes', 'nice shoes', 'A pair of stylish and comfortable shoes suitable for everyday wear. Features durable material and a sleek design.', 2, 'Nike', 'Air Max', 1, 1, 70);


INSERT INTO Images (imagePath) VALUES
('../docs/itemImages/smartphone.jpg'),
('../docs/itemImages/smartphone2.jpg'),
('../docs/itemImages/smartphone3.jpg'),
('../docs/itemImages/bicycle.jpg'),
('../docs/itemImages/laptop.jpg'),
('../docs/itemImages/dress.jpg'),
('../docs/itemImages/shoes.jpg'),
('../docs/userImages/ronaldo.jpg');

INSERT INTO ItemImages (idItem, idImage, isMain) VALUES
(1, 1, TRUE),
(1, 2, FALSE),
(1, 3, FALSE),
(2, 4, TRUE),
(3, 5, TRUE),
(4, 6, TRUE),
(5, 7, TRUE);

INSERT INTO UserImage (idUser, idImage) VALUES
(2, 8);

INSERT INTO Chats (idSender, idRecipient, message) VALUES
(2, 1, 'Hello come to al-nassr!'),
(1, 2, 'Sure! What specific details would you like to know?');

INSERT INTO Orders (idBuyer, totalPrice) VALUES
(2, 200.00),
(2, 150.00);

INSERT INTO OrderItems (idOrder, idItem) VALUES
(1, 1),
(2, 2);

INSERT INTO Wishlists (idUser, idItem) VALUES
(1, 3),
(1, 4),
(2, 4),
(2, 1),
(3, 5);