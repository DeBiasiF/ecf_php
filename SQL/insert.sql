INSERT INTO __role (name_role)
    VALUES
        ('Lepremier'),
        ('Lesecond')
        ;


INSERT INTO category (name_category)
    VALUES
        ('Lepremier'),
        ('Lesecond')
        ;



INSERT INTO __user (name___user, password___user, quantity_points___user, Id_role)
    VALUES
        ('','', '', '')
        ;

INSERT INTO goods (img_goods, description_goods, status_goods, Id_category, Id___user_lender)
    VALUES
        ('','', '', '', '')
        ;

INSERT INTO borrowing (start_borrowing, end_borrowing, Id___user_borrower, Id_goods)
    VALUES
        ('','', '', '')
        ;