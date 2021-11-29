DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS privateMessages CASCADE;
DROP TABLE IF EXISTS projects CASCADE;
DROP TABLE IF EXISTS projectUsers CASCADE;
DROP TABLE IF EXISTS favoriteProjects CASCADE;
DROP TABLE IF EXISTS invitations CASCADE;
DROP TABLE IF EXISTS projectMessages CASCADE;
DROP TABLE IF EXISTS projectFiles CASCADE;
DROP TABLE IF EXISTS reports CASCADE;
DROP TABLE IF EXISTS tasks CASCADE;
DROP TABLE IF EXISTS userAssigns CASCADE;
DROP TABLE IF EXISTS taskComments CASCADE;
DROP TABLE IF EXISTS notifications CASCADE;

--types

DROP TYPE IF EXISTS notificationType;
DROP TYPE IF EXISTS reportState;
DROP TYPE IF EXISTS reportType;
DROP TYPE IF EXISTS stage;
DROP TYPE IF EXISTS userRole;

CREATE TYPE notificationType AS ENUM (
    'INVITE',
    'FORUM',
    'REPORT',
    'MESSAGE',
    'REMINDER',
    'COMMENT'
);


CREATE TYPE reportState AS ENUM (
    'PENDING',
    'IGNORED',
    'BANNED'
);


CREATE TYPE reportType AS ENUM (
    'USER',
    'BUG'
);


CREATE TYPE stage AS ENUM (
    'TODO',
    'DOING',
    'REVIEW',
    'CLOSED'
);


CREATE TYPE userRole AS ENUM (
    'GUEST',
    'MEMBER',
    'MANAGER'
);


--tables

CREATE TABLE users
(
    id serial,
    username varchar NOT NULL UNIQUE,
    fullname varchar,
    email varchar NOT NULL UNIQUE,
    password varchar NOT NULL,
    img_url varchar,
    is_admin boolean NOT NULL DEFAULT false,
    CONSTRAINT users_pk PRIMARY KEY (id)
);

CREATE TABLE privateMessages --falta povoar
(
    id serial,
    message varchar NOT NULL,
    emitter_id integer NOT NULL,
    receiver_id integer NOT NULL,
    read boolean NOT NULL DEFAULT false,
    created_at date NOT NULL,
    CONSTRAINT private_messages_pk PRIMARY KEY (id),
    CONSTRAINT emitter_fk FOREIGN KEY (emitter_id)
        REFERENCES users (id)
        ON DELETE CASCADE,
    CONSTRAINT receiver_fk FOREIGN KEY (receiver_id)
        REFERENCES users (id)
        ON DELETE CASCADE
);

CREATE TABLE projects
(
    id serial,
    title varchar NOT NULL,
    description varchar NOT NULL,
    public boolean NOT NULL DEFAULT true,
    active boolean NOT NULL DEFAULT true,
    created_at date NOT NULL,
    CONSTRAINT projects_pk PRIMARY KEY (id)
);

CREATE TABLE projectUsers
(
    user_id integer NOT NULL,
    project_id integer NOT NULL,
    user_role userRole NOT NULL,
    CONSTRAINT project_users_pk PRIMARY KEY (user_id, project_id),
    CONSTRAINT project_fk FOREIGN KEY (project_id)
        REFERENCES projects (id)
        ON DELETE CASCADE,
    CONSTRAINT user_fk FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE CASCADE
);

CREATE TABLE favoriteProjects
(
    user_id integer NOT NULL,
    project_id integer NOT NULL,
    CONSTRAINT favoriteProjects_pk PRIMARY KEY (user_id, project_id),
    CONSTRAINT project_fk FOREIGN KEY (project_id)
        REFERENCES projects (id)
        ON DELETE CASCADE,
    CONSTRAINT user_fk FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE CASCADE
);

CREATE TABLE invitations
(
    user_id integer NOT NULL,
    project_id integer NOT NULL,
    accept boolean,
    CONSTRAINT invitations_pk PRIMARY KEY (user_id, project_id),
    CONSTRAINT project_fk FOREIGN KEY (project_id)
        REFERENCES projects (id)
        ON DELETE CASCADE,
    CONSTRAINT user_fk FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE CASCADE
);

CREATE TABLE projectMessages
(
    id serial,
    message varchar NOT NULL,
    user_id integer,
    project_id integer,
    created_at date NOT NULL,
    CONSTRAINT projectMessages_pk PRIMARY KEY (id),
    CONSTRAINT project_fk FOREIGN KEY (project_id)
        REFERENCES projects (id)
        ON DELETE CASCADE,
    CONSTRAINT user_fk FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE CASCADE
);

CREATE TABLE projectFiles
(
    id serial,
    url varchar NOT NULL UNIQUE,
    project_id integer,
    created_at date NOT NULL,
    updated_at date NOT NULL,
    CONSTRAINT project_files_pk PRIMARY KEY (id),
    CONSTRAINT project_fk FOREIGN KEY (project_id)
        REFERENCES projects (id)
        ON DELETE CASCADE
);

CREATE TABLE reports
(
    id serial,
    user_id integer,
    text varchar NOT NULL,
    report_type reportType NOT NULL,
    created_at date NOT NULL,
    report_state reportState NOT NULL DEFAULT 'PENDING',
    reported_user_id integer,
    CONSTRAINT reports_pkey PRIMARY KEY (id),
    CONSTRAINT reported_user_fk FOREIGN KEY (reported_user_id)
        REFERENCES users (id)
        ON DELETE CASCADE,
    CONSTRAINT user_fk FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE CASCADE,
    CONSTRAINT report_type_ck CHECK (report_type = ANY (ARRAY['USER'::reportType, 'BUG'::reportType])),
    CONSTRAINT report_state_ck CHECK (report_state = ANY (ARRAY['PENDING'::reportState, 'IGNORED'::reportState, 'BANNED'::reportState]))
);

CREATE TABLE tasks
(
    id serial,
    name varchar NOT NULL,
    description varchar NOT NULL,
    due_date date NOT NULL,
    reminder_date date,
    tag stage NOT NULL,
    creator_id integer,
    project_id integer,
    created_at date NOT NULL,
    CONSTRAINT tasks_pk PRIMARY KEY (id),
    CONSTRAINT creator_fk FOREIGN KEY (creator_id)
        REFERENCES users (id)
        ON DELETE CASCADE,
    CONSTRAINT project_fk FOREIGN KEY (project_id)
        REFERENCES projects (id)
        ON DELETE CASCADE,
    CONSTRAINT due_date_ck CHECK (due_date >= created_at),
    CONSTRAINT reminder_date_ck CHECK (reminder_date >= created_at AND reminder_date <= due_date),
    CONSTRAINT tag_ck CHECK (tag = ANY (ARRAY['TODO'::stage, 'DOING'::stage, 'REVIEW'::stage, 'CLOSED'::stage]))
);

CREATE TABLE userAssigns
(
    user_id integer NOT NULL,
    task_id integer NOT NULL,
    CONSTRAINT userAssigns_pk PRIMARY KEY (user_id, task_id)
);

CREATE TABLE taskComments
(
    id serial,
    comment varchar NOT NULL,
    task_id integer,
    user_id integer,
    created_at date NOT NULL,
    CONSTRAINT taskComments_pk PRIMARY KEY (id),
    CONSTRAINT user_fk FOREIGN KEY (user_id)
        REFERENCES users (id)
        ON DELETE CASCADE,
    CONSTRAINT task_fk FOREIGN KEY (task_id)
        REFERENCES tasks (id)
        ON DELETE CASCADE
);

CREATE TABLE notifications --povoar
(
    id serial,
    notification_type notificationType NOT NULL,
    created_at date NOT NULL,
    user_id integer NOT NULL,
    invitation_user_id integer,
    project_message_id integer,
    report_id integer,
    private_message_id integer,
    task_id integer,
    task_comment_id integer,
    invitation_project_id integer,
    CONSTRAINT notifications_pk PRIMARY KEY (id),
    CONSTRAINT invitation_fk FOREIGN KEY (invitation_project_id, invitation_user_id)
        REFERENCES invitations (project_id, user_id) 
        ON DELETE CASCADE,
    CONSTRAINT private_message_fk FOREIGN KEY (private_message_id)
        REFERENCES privateMessages (id) 
        ON DELETE CASCADE,
    CONSTRAINT project_message_fk FOREIGN KEY (project_message_id)
        REFERENCES projectMessages (id) 
        ON DELETE CASCADE,
    CONSTRAINT report_fk FOREIGN KEY (report_id)
        REFERENCES reports (id) 
        ON DELETE CASCADE,
    CONSTRAINT task_comment_fk FOREIGN KEY (task_comment_id)
        REFERENCES taskComments (id) 
        ON DELETE CASCADE,
    CONSTRAINT task_fk FOREIGN KEY (task_id)
        REFERENCES tasks (id) 
        ON DELETE CASCADE,
    CONSTRAINT user_fk FOREIGN KEY (user_id)
        REFERENCES users (id) 
        ON DELETE CASCADE,
    CONSTRAINT notification_type_ck CHECK (notification_type = ANY (ARRAY['INVITE'::notificationType, 'FORUM'::notificationType, 'REPORT'::notificationType, 'MESSAGE'::notificationType, 'REMINDER'::notificationType, 'COMMENT'::notificationType]))
);

--PlanWiser Indexes
DROP INDEX IF EXISTS private_messages_index;
DROP INDEX IF EXISTS projects_index;
DROP INDEX IF EXISTS project_user_by_user;
DROP INDEX IF EXISTS project_user_by_project;
DROP INDEX IF EXISTS invitations_by_project;
DROP INDEX IF EXISTS favorite_projects_by_use;
DROP INDEX IF EXISTS favorite_projects_by_project;
DROP INDEX IF EXISTS project_messages_index;
DROP INDEX IF EXISTS project_files_by_project;
DROP INDEX IF EXISTS reports_by_type;
DROP INDEX IF EXISTS reports_index;
DROP INDEX IF EXISTS notifications_by_type;
DROP INDEX IF EXISTS notifications_index;
DROP INDEX IF EXISTS tasks_index;
DROP INDEX IF EXISTS users_assign_by_task;
DROP INDEX IF EXISTS users_assign_by_user;
DROP INDEX IF EXISTS task_comments_index;
DROP INDEX IF EXISTS search_user;
DROP INDEX IF EXISTS search_project;
DROP INDEX IF EXISTS search_task;


--IDX01
CREATE INDEX private_messages_index ON privateMessages USING btree(emitter_id, receiver_id, created_at);  
CLUSTER privateMessages USING private_messages_index;

--IDX02
CREATE INDEX projects_index ON projects USING btree(create_at);  
CLUSTER projects USING projects_index;

--IDX03
CREATE INDEX project_user_by_user ON projectUsers USING hash(user_id);  
CLUSTER projectUsers USING project_user_by_user;

--IDX04
CREATE INDEX project_user_by_project ON projectUsers USING hash(project_id);

--IDX05
CREATE INDEX invitations_by_project ON invitations USING hash(project_id);  
CLUSTER invitations USING invitations_by_user;

--IDX06
CREATE INDEX favorite_projects_by_user ON favoriteProjects USING hash(user_id);  
CLUSTER favoriteProjects USING favorite_projects_by_user;

--IDX07
CREATE INDEX favorite_projects_by_project ON favoriteProjects USING hash(project_id);

--IDX08
CREATE INDEX project_messages_index ON projectMessages USING btree(user_id, project_id, created_at);  
CLUSTER projectMessages USING project_messages_index;

--IDX09
CREATE INDEX project_files_by_project ON projectFiles USING hash(project_id);  
CLUSTER projectFiles USING project_files_by_user;

--IDX10
CREATE INDEX reports_by_type ON reports USING hash(report_type);

--IDX11
CREATE INDEX reports_index ON reports USING btree(create_at);  
CLUSTER reports USING preports_index;

--IDX12
CREATE INDEX notifications_by_type ON notifications USING hash(notification_type);

--IDX13
CREATE INDEX notifications_index ON notifications USING btree(create_at);  CLUSTER notifications USING notifications_index;

--IDX14
CREATE INDEX tasks_index ON tasks USING btree(project_id, due_date);  CLUSTER tasks USING tasks_index;

--IDX15
CREATE INDEX users_assign_by_task ON usersAssign USING hash(task_id);  
CLUSTER usersAssign USING users_assign_by_task;

--IDX16
CREATE INDEX users_assign_by_user ON UsersAssign USING hash(user_id);

--IDX17
CREATE INDEX task_comments_index ON taskComments USING btree(task_id, created_at);  
CLUSTER taskComments USING task_comments_index;

--IDX18
CREATE INDEX search_user ON users USING GIN (search);

--IDX19
CREATE INDEX search_project ON projects USING GIN (search);

--IDX20
CREATE INDEX search_task ON tasks USING GIN (search);