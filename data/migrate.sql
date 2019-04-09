INSERT INTO 
    `roles` 
    (`slug`, `name`) 
VALUES
    ('ROLE_ADMIN', 'Admin'),
    ('ROLE_USER', 'User'),
    ('ROLE_GROUP_USER', 'Group User');

INSERT INTO 
    `users` 
    (`name`, `email`, `password`, `createdById`, `roleId`) 
VALUES
    ('Admin User', 'admin@internations-demo.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 1),
    ('Normal User', 'user@internations-demo.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 2);