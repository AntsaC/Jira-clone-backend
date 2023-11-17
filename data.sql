insert into project_type(id, name)
values (1, 'Agile project'),
       (2, 'IT project'),
       (3, 'RH project');

insert into project(id, type_id, name, key, created_at)
values (1, 1, 'Project 1', 'PDT', '2023-10-10'),
       (2, 1, 'Project 2', 'PDT', '2023-10-15'),
       (3, 2, 'Project 3', 'PDT', '2023-10-20'),
       (4, 3, 'Project 4', 'PDT', '2023-11-10'),
       (5, 2, 'Project 5', 'PDT', '2023-11-11'),
       (6, 2, 'Qice 1', 'PDT', '2023-11-12'),
       (7, 2, 'Qice 2', 'PDT', '2023-11-13');

select setval('project_id_seq' , 100);
select setval('project_type_id_seq' , 100);
