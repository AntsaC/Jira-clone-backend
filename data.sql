insert into project_type(id, name)
values (1, 'Agile project'),
       (2, 'IT project'),
       (3, 'RH project');

insert into project(id, type_id, name, key, created_at)
values (1, 1, 'Project 1', 'PD1', '2023-10-10'),
       (2, 1, 'Project 2', 'PD2', '2023-10-15'),
       (3, 2, 'Project 3', 'PD3', '2023-10-20'),
       (4, 3, 'Project 4', 'PD4', '2023-11-10'),
       (5, 2, 'Project 5', 'PD5', '2023-11-11'),
       (6, 2, 'Qice 1', 'PD6', '2023-11-12'),
       (7, 2, 'Qice 2', 'PD7', '2023-11-13');

insert into sprint(id, project_id, name, start_date, end_date)
values (1, 1, 'PD1 Sprint 1', '2023-11-10', '2023-11-20'),
       (2, 1, 'PD1 Sprint 2', '2023-11-20', '2023-11-30'),
       (3, 1, 'PD1 Sprint 3', null, null);

insert into user_story(id, project_id, summary, sprint_id)
values (1, 1, 'My first user story', 1),
       (2, 1, 'My second user story', 1),
       (3, 2, 'My third user story', 2),
       (4, 3, 'My fourth user story', null),
       (5, 2, 'My fifth user story', 2),
       (6, 1, 'Create new task', null),
       (8, 1, 'Add new product', null);


select setval('project_id_seq' , 100);
select setval('project_type_id_seq' , 100);
select setval('user_story_id_seq' , 100);
select setval('sprint_id_seq', 100);
