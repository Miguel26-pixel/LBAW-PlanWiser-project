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