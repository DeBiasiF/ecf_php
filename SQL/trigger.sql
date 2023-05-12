
CREATE OR REPLACE FUNCTION delete_goods()
RETURNS trigger AS
$$
BEGIN
    IF EXISTS (SELECT 1 FROM borrowing WHERE id___user_borrower = OLD.id___user AND CURRENT_DATE BETWEEN start_borrowing AND end_borrowing) THEN
        RAISE EXCEPTION 'User still has rented goods';
    ELSE
        DELETE FROM goods WHERE id___user_lender = OLD.id___user;
        RETURN OLD;
    END IF;
END;
$$
LANGUAGE plpgsql;

CREATE TRIGGER delete_goods_trigger
BEFORE DELETE ON __user
FOR EACH ROW
EXECUTE FUNCTION delete_goods();


