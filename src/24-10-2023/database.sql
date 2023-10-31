-- Tạo cơ sở dữ liệu

CREATE DATABASE QuanLyBanHang;

-- Sử dụng cơ sở dữ liệu

USE QuanLyBanHang;

-- Tạo bảng Sản phẩm (Products)

CREATE TABLE Products (

ProductID INT AUTO_INCREMENT PRIMARY KEY,

ProductName VARCHAR(255) NOT NULL,

Description TEXT,

Price DECIMAL(10, 2) NOT NULL,

StockQuantity INT NOT NULL

);

-- Tạo bảng Khách hàng (Customers)

CREATE TABLE Customers (

CustomerID INT AUTO_INCREMENT PRIMARY KEY,

FirstName VARCHAR(50) NOT NULL,

LastName VARCHAR(50) NOT NULL,

Email VARCHAR(100),

Phone VARCHAR(20)

);

-- Tạo bảng Đơn hàng (Orders)

CREATE TABLE Orders (

OrderID INT AUTO_INCREMENT PRIMARY KEY,

CustomerID INT,

OrderDate DATE,

FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)

);

-- Tạo bảng Chi tiết đơn hàng (OrderDetails)

CREATE TABLE OrderDetails (

OrderDetailID INT AUTO_INCREMENT PRIMARY KEY,

OrderID INT,

ProductID INT,

Quantity INT NOT NULL,

Price DECIMAL(10, 2) NOT NULL,

FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),

FOREIGN KEY (ProductID) REFERENCES Products(ProductID)

);
