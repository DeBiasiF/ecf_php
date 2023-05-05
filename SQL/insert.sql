INSERT INTO __role (name___role)
    VALUES
        ('Admin'),
        ('Client')
        ;


INSERT INTO category (name_category, valor_point_cat_egory)
    VALUES
        ('Électronique', 10),
        ('Mode et accessoires', 3),
        ('Instruments de musique', 5),
        ('Livres et magazines', 7),
        ('Sports et loisirs', 10),
        ('Jeux et jouets', 8)
        ;



INSERT INTO __user (name___user, password___user, quantity_points___user, id___role)
    VALUES
        ('Admin','$2y$10$OaHSkdgtrX8KNy9fS2N2DuOlDSW3L8ZzSXyu3a2hd/3cnislIIMc2', '0', '1')
        ;

INSERT INTO goods (img_goods, description_goods, status_goods, id_category, id___user_lender)
    VALUES
        ('','', '', '', '')
        ;

INSERT INTO borrowing (start_borrowing, end_borrowing, id___user_borrower, id_goods)
    VALUES
        ('','', '', '')
        ;