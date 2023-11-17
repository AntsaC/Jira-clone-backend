insert into project_type(id, name)
values (1, 'Agile project'),
       (2, 'IT project'),
       (3, 'RH project');

insert into project(id, type_id, name, key)
values (1, 1, 'Project 1', 'PDT'),
       (2, 1, 'Project 2', 'PDT'),
       (3, 2, 'Project 3', 'PDT'),
       (4, 3, 'Project 4', 'PDT'),
       (5, 2, 'Project 5', 'PDT'),
       (6, 2, 'Qice 1', 'PDT'),
       (7, 2, 'Qice 2', 'PDT');