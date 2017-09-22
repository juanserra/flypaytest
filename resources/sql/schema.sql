CREATE TABLE IF NOT EXISTS payments (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    amount FLOAT NOT NULL,
    tip FLOAT,
    table_number INTEGER NOT NULL,
    location_id INTEGER NOT NULL,
    payment_reference VARCHAR(30),
    card_type VARCHAR(10),
    processed_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    customer_id VARCHAR(10),
    customer_device VARCHAR(30)
);