INSERT INTO "user" (id, username, email, roles, password)
VALUES (1, 'john_doe', 'john.doe@example.com', '{
  "role": "user"
}', 'securepass1'),
       (2, 'jane_smith', 'jane.smith@example.com', '{
         "role": "admin"
       }', 'strongpass2'),
       (3, 'alice_jones', 'alice.jones@example.com', '{
         "role": "user"
       }', 'password123'),
       (4, 'bob_miller', 'bob.miller@example.com', '{
         "role": "editor"
       }', 'secretword4'),
       (5, 'emma_wilson', 'emma.wilson@example.com', '{
         "role": "user"
       }', 'p@ssw0rd');

insert into project_type(id, name)
values (1, 'Agile project'),
       (2, 'IT project'),
       (3, 'RH project');

insert into project(id, type_id, name, key, created_at, current_sprint_index, lead_id)
values (1, 1, 'Project 1', 'PD1', '2023-10-10', 2, 1),
       (2, 1, 'Project 2', 'PD2', '2023-10-15', 0, 2),
       (3, 2, 'Project 3', 'PD3', '2023-10-20', 0, 1),
       (4, 3, 'Project 4', 'PD4', '2023-11-10', 0, 3),
       (5, 2, 'Project 5', 'PD5', '2023-11-11', 0, 4),
       (6, 2, 'Qice 1', 'PD6', '2023-11-12', 0, null),
       (7, 2, 'Qice 2', 'PD7', '2023-11-13', 0, null);

INSERT INTO collaboration (id, project_id, collaborator_id)
VALUES (1, 1, 1),
       (2, 1, 2),
       (3, 1, 3),
       (4, 1, 4),
       (6, 2, 1),
       (7, 2, 2),
       (10, 2, 5),
       (11, 3, 1),
       (14, 3, 4),
       (15, 3, 5);

insert into sprint(id, project_id, name, start_date, end_date,goal)
values (1, 1, 'PD1 Sprint 1', '2023-11-10', '2023-11-20', 'First goal'),
       (2, 1, 'PD1 Sprint 2', '2023-12-10', '2023-12-20', 'Second goal'),
       (3, 1, 'PD1 Sprint 3', '2024-01-01', '2024-01-10', 'Third goal'),
       (6, 1, 'PD1 Sprint 4', null, null, null),
       (4, 3, 'PD3 Sprint 1', '2023-10-10', '2023-10-20', null),
       (5, 3, 'PD3 Sprint 2', null, null, null);

insert into story_status(id, name)
values (1,'TODO'),
       (2,'IN PROGRESS'),
       (3,'DONE');

insert into user_story(id, project_id, summary, sprint_id, story_point, previous_id, status_id)
values (1, 1, 'Project 1 first user story', 1, 5, null, 3),
       (5, 2, 'Project 2 first user story', 2, 4, null, 2),
       (3, 2, 'Project 2 user story', 2, 3, 5, null),
       (2, 1, 'Project 1 third user story', 1, 2, 1, 1),
       (4, 3, 'Project 3 first user story', null, null, null, 1),
       (6, 1, 'Project 1 Create new task', 1, 3, 2, 3),
       (8, 1, 'Project 1 Add new product', null, 6, null, 2),
       (7, 1, 'Project 1 List products', null, 6, 8, 1);

update user_story
set previous_id = 1
where id = 6;
update user_story
set previous_id = 6
where id = 2;

insert into criteria_acceptance(id, user_story_id, criteria, checked)
values (1, 1, 'Simple criteria', false),
       (2, 1, 'Simple criteria 1', true),
       (3, 3, 'Simple criteria 2', false),
       (4, 4, 'Simple criteria 3', true);

SELECT setval('project_id_seq', COALESCE(MAX(id), 1) + 1, false)
FROM project;
SELECT setval('project_type_id_seq', COALESCE(MAX(id), 1) + 1, false)
FROM project_type;
SELECT setval('user_story_id_seq', COALESCE(MAX(id), 1) + 1, false)
FROM user_story;
SELECT setval('sprint_id_seq', COALESCE(MAX(id), 1) + 1, false)
FROM sprint;
SELECT setval('criteria_acceptance_id_seq', COALESCE(MAX(id), 1) + 1, false)
FROM criteria_acceptance;
SELECT setval('user_id_seq', COALESCE(MAX(id), 1) + 1, false)
FROM "user";


