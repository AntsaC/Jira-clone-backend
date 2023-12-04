insert into project_type(id, name)
values (1, 'Agile project'),
       (2, 'IT project'),
       (3, 'RH project');

insert into project(id, type_id, name, key, created_at, current_sprint_index)
values (1, 1, 'Project 1', 'PD1', '2023-10-10', 2),
       (2, 1, 'Project 2', 'PD2', '2023-10-15', 0),
       (3, 2, 'Project 3', 'PD3', '2023-10-20', 0),
       (4, 3, 'Project 4', 'PD4', '2023-11-10', 0),
       (5, 2, 'Project 5', 'PD5', '2023-11-11', 0),
       (6, 2, 'Qice 1', 'PD6', '2023-11-12', 0),
       (7, 2, 'Qice 2', 'PD7', '2023-11-13', 0);

insert into sprint_status(id, name)
values (1,'finish'),
       (2,'current'),
       (3,'future');

insert into sprint(id, project_id, name, start_date, end_date, status_id)
values (1, 1, 'PD1 Sprint 1', '2023-11-10', '2023-11-20', 1),
       (2, 1, 'PD1 Sprint 2', '2023-11-20', '2023-11-30', 2),
       (3, 1, 'PD1 Sprint 3', null, null, 3),
       (4, 3, 'PD3 Sprint 1', '2023-10-10', '2023-10-20', 1),
       (5, 3, 'PD3 Sprint 2', null, null, 2);

insert into user_story(id, project_id, summary, sprint_id, story_point)
values (1, 1, 'My first user story', 1, 5),
       (2, 1, 'My second user story', 1, 2),
       (3, 2, 'My third user story', 2, 3),
       (4, 3, 'My fourth user story', null, null),
       (5, 2, 'My fifth user story', 2, 4),
       (6, 1, 'Create new task', null, 3),
       (8, 1, 'Add new product', null, 6);

insert into criteria_acceptance(id, user_story_id, criteria, checked)
values (1, 1, 'Simple criteria', false),
       (2, 1, 'Simple criteria 1', true),
       (3, 3, 'Simple criteria 2', false),
       (4, 4, 'Simple criteria 3', true);

select setval('project_id_seq' , 100);
select setval('project_type_id_seq' , 100);
select setval('user_story_id_seq' , 100);
select setval('sprint_id_seq', 100);
select setval('criteria_acceptance_id_seq', 100);
