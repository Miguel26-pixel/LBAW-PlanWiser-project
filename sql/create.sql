SET search_path TO teste;


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
    search TSVECTOR,
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
    search TSVECTOR,
    CONSTRAINT projects_pk PRIMARY KEY (id)
);

CREATE TABLE projectUsers
(
    user_id integer NOT NULL,
    project_id integer NOT NULL,
    user_role userRole NOT NULL DEFAULT 'GUEST',
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
    search TSVECTOR,
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

--functions

CREATE OR REPLACE FUNCTION check_private_message() RETURNS TRIGGER AS
$BODY$
BEGIN
    if new.receiver_id in (select user_id from projectUsers where project_id in (select id from projects where id in (select project_id from projectUsers where user_id = new.emitter_id)))
    then 
        return new;
    else
        raise exception 'The users dont have projects in common';
    end if;
END;
$BODY$
    LANGUAGE plpgsql;



CREATE OR REPLACE FUNCTION check_project_message() RETURNS TRIGGER AS
$BODY$
BEGIN
    if new.user_id in (select user_id from projectUsers where project_id = new.project_id)
    then 
        if 'GUEST' in (select user_role from projectUsers where user_id = new.user_id and project_id = new.project_id limit 1)
        then raise exception 'The user dont have permissions to send messages';
        else return new;
        end if;
    else
        raise exception 'The user dont belong to the project so he cant send messages';
    end if;
END;
$BODY$
    LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION check_user_task() RETURNS TRIGGER AS
$BODY$
BEGIN
    if new.creator_id in (select user_id from projectUsers where project_id = new.project_id)
    then 
        if 'MANAGER' in (select user_role from projectUsers where user_id = new.creator_id and project_id = new.project_id limit 1)
        then return new;
        else raise exception 'The user dont have permissions to create tasks';
        end if;
    else
        raise exception 'The user dont belong to the project so he cant create tasks';
    end if;
END;
$BODY$
    LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION check_task_assign() RETURNS TRIGGER AS
$BODY$
BEGIN
    if new.user_id in (select pu.user_id from tasks as t
                            join projects as p on t.project_id = p.id
                            join projectUsers as pu on pu.project_id = p.id
                            where t.id = new.task_id)
    then 
        if 'GUEST' in (select pu.user_role from tasks as t
                            join projects as p on t.project_id = p.id
                            join projectUsers as pu on pu.project_id = p.id
                            where t.id = new.task_id and pu.user_id = new.user_id)
        then raise exception 'The user cannot be assigned to tasks';
        else return new;
        end if;
    else
        raise exception 'The user dont belong to the project so he cannot be assigned to tasks';
    end if;
END;
$BODY$
    LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION add_invite_notification() RETURNS TRIGGER AS
$BODY$
BEGIN

    INSERT INTO notifications (created_at, notification_type, user_id, invitation_user_id, invitation_project_id)
    VALUES (NOW(), 'INVITE', NEW.user_id, NEW.user_id, NEW.project_id);
    RETURN NEW;
END;
$BODY$
    LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION add_forum_notification() RETURNS TRIGGER AS
$BODY$
BEGIN

    INSERT INTO notifications (created_at, notification_type, user_id, project_message_id)
    VALUES (NOW(), 'FORUM', NEW.user_id, NEW.id);
    RETURN NEW;
END;
$BODY$
    LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION add_report_notification() RETURNS TRIGGER AS
$BODY$
BEGIN

    INSERT INTO notifications (created_at, notification_type, user_id, report_id)
    VALUES (NOW(), 'REPORT', NEW.user_id, NEW.id);
    RETURN NEW;
END;    
$BODY$
    LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION add_message_notification() RETURNS TRIGGER AS
$BODY$
BEGIN

    INSERT INTO notifications (created_at, notification_type, user_id, private_message_id)
    VALUES (NOW(), 'MESSAGE', NEW.emitter_id, NEW.id);
    RETURN NEW;
END;
$BODY$
    LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION add_reminder_notification() RETURNS TRIGGER AS
$BODY$
BEGIN

    INSERT INTO notifications (created_at, notification_type, user_id, task_id)
    VALUES (NOW(), 'REMINDER', NEW.creator_id, NEW.id);
    RETURN NEW;
END;
$BODY$
    LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION add_comment_notification() RETURNS TRIGGER AS
$BODY$
BEGIN

    INSERT INTO notifications (created_at, notification_type, user_id, task_comment_id)
    VALUES (NOW(), 'COMMENT', NEW.user_id, NEW.id );
    RETURN NEW;
END;
$BODY$
    LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION users_search_update() RETURNS TRIGGER AS 
$BODY$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.search = (SELECT setweight(to_tsvector(NEW.username), 'A')  || setweight(to_tsvector(users.email), 'A') || setweight(to_tsvector(users.fullname), 'B') FROM users WHERE NEW.id=users.id);
    ELSIF TG_OP = 'UPDATE' AND (NEW.username <> OLD.username) THEN
        NEW.search = (SELECT setweight(to_tsvector(NEW.username), 'A')  || setweight(to_tsvector(users.email), 'A') || setweight(to_tsvector(users.fullname), 'B') FROM users WHERE NEW.id=users.id);
    END IF;
    RETURN NEW;
END;
$BODY$
    LANGUAGE 'plpgsql';



CREATE OR REPLACE FUNCTION projects_search_update() RETURNS TRIGGER AS 
$BODY$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.search = (SELECT setweight(to_tsvector(NEW.title), 'A') || setweight(to_tsvector(NEW.description), 'B'));
    ELSIF TG_OP = 'UPDATE' AND (NEW.title <> OLD.title OR NEW.description <> OLD.description) THEN
        NEW.search = (SELECT setweight(to_tsvector(NEW.title), 'A') || setweight(to_tsvector(NEW.description), 'B'));
    END IF;
    RETURN NEW;
END;
$BODY$
    LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION tasks_search_update() RETURNS TRIGGER AS 
$BODY$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.search = (SELECT setweight(to_tsvector(NEW.name), 'A') || setweight(to_tsvector(NEW.description), 'B'));
    ELSIF TG_OP = 'UPDATE' AND (NEW.name <> OLD.name OR NEW.description <> OLD.description) THEN
        NEW.search = (SELECT setweight(to_tsvector(NEW.name), 'A') || setweight(to_tsvector(NEW.description), 'B'));
    END IF;
    RETURN NEW;
END;
$BODY$
    LANGUAGE 'plpgsql';


CREATE OR REPLACE FUNCTION add_project_user() RETURNS TRIGGER AS
$BODY$
BEGIN
    if new.accept is true 
    then INSERT INTO projectUsers (user_id, project_id, user_role) 
         VALUES ((SELECT NEW.user_id, NEW.project_id, NEW.user_role FROM NEW));
    else 
        raise exception 'The invite was declined';
    end if;
END;
$BODY$
    LANGUAGE plpgsql;
    

CREATE OR REPLACE FUNCTION check_notification_type() RETURNS TRIGGER AS
$BODY$
BEGIN
    if  
        (invitation_user_id <> NULL and invitation_project_id <> NULL and new.notification_type = 'INVITE' and project_message_id = NULL and report_id = NULL and private_message_id = NULL and task_id = NULL and task_comment_id = NULL)
    then 
        INSERT INTO notifications (created_at, notification_type, invitation_user_id, invitation_project_id)
        VALUES (NOW(), 'INVITE',(SELECT NEW.invitation_user_id, NEW.invitation_project_id FROM NEW));
    elsif  
        (project_message_id <> NULL and new.notification_type = 'FORUM' and invitation_user_id = NULL and invitation_project_id = NULL and report_id = NULL and private_message_id = NULL and task_id = NULL and task_comment_id = NULL)
    then
        INSERT INTO notifications (created_at, notification_type, project_message_id)
        VALUES (NOW(), 'FORUM',(SELECT NEW.project_message_id FROM NEW));
	elsif  
        (project_message_id = NULL and new.notification_type = 'REPORT' and invitation_user_id = NULL and invitation_project_id = NULL and report_id <> NULL and private_message_id = NULL and task_id = NULL and task_comment_id = NULL)
    then
        INSERT INTO notifications (created_at, notification_type, report_id)
        VALUES (NOW(), 'REPORT',(SELECT NEW.report_id FROM NEW));
	elsif  
        (project_message_id = NULL and new.notification_type = 'MESSAGE' and invitation_user_id = NULL and invitation_project_id = NULL and report_id = NULL and private_message_id <> NULL and task_id = NULL and task_comment_id = NULL)
    then
        INSERT INTO notifications (created_at, notification_type, private_message_id)
        VALUES (NOW(), 'MESSAGE',(SELECT NEW.private_message_id FROM NEW));
    elsif  
        (project_message_id = NULL and new.notification_type = 'REMINDER' and invitation_user_id = NULL and invitation_project_id = NULL and report_id = NULL and private_message_id = NULL and task_id <> NULL and task_comment_id = NULL)
    then
        INSERT INTO notifications (created_at, notification_type, task_id)
        VALUES (NOW(), 'REMINDER',(SELECT NEW.task_id FROM NEW));
	elsif  
        (project_message_id = NULL and new.notification_type = 'COMMENT' and invitation_user_id = NULL and invitation_project_id = NULL and report_id = NULL and private_message_id = NULL and task_id = NULL and task_comment_id <> NULL)
    then
        INSERT INTO notifications (created_at, notification_type, task_comment_id)
        VALUES (NOW(), 'COMMENT',(SELECT NEW.task_comment_id FROM NEW));
    else
        raise exception 'Invalid notification';
    end if;
END;
$BODY$
    LANGUAGE plpgsql;
    
    
--triggers



DROP TRIGGER IF EXISTS check_private_message ON privateMessages;
DROP TRIGGER IF EXISTS check_user_project ON projectMessages;
DROP TRIGGER IF EXISTS check_user_task ON tasks;
DROP TRIGGER IF EXISTS check_task_assign ON userAssigns;
DROP TRIGGER IF EXISTS add_invite_notification ON invitations;
DROP TRIGGER IF EXISTS add_forum_notification ON projectMessages;
DROP TRIGGER IF EXISTS add_report_notification ON reports;
DROP TRIGGER IF EXISTS add_message_notification ON privateMessages;
DROP TRIGGER IF EXISTS add_reminder_notification ON tasks;
DROP TRIGGER IF EXISTS add_comment_notification ON taskComments;
DROP TRIGGER IF EXISTS add_project_user ON invitations;
DROP TRIGGER IF EXISTS check_notification_type ON notifications;


CREATE TRIGGER check_private_message
    BEFORE INSERT
    ON privateMessages
    FOR EACH ROW
EXECUTE PROCEDURE check_private_message();

CREATE TRIGGER check_user_project
    BEFORE INSERT
    ON projectMessages
    FOR EACH ROW
EXECUTE PROCEDURE check_project_message();

CREATE TRIGGER check_user_task
    BEFORE INSERT
    ON tasks
    FOR EACH ROW
EXECUTE PROCEDURE check_user_task();

CREATE TRIGGER check_task_assign
    BEFORE INSERT
    ON userAssigns
    FOR EACH ROW
EXECUTE PROCEDURE check_task_assign();

CREATE TRIGGER add_invite_notification
    AFTER INSERT
    ON invitations
    FOR EACH ROW
EXECUTE PROCEDURE add_invite_notification(); 

CREATE TRIGGER add_forum_notification
    AFTER INSERT
    ON projectMessages
    FOR EACH ROW
EXECUTE PROCEDURE add_forum_notification(); 

CREATE TRIGGER add_report_notification
    AFTER INSERT
    ON reports
    FOR EACH ROW
EXECUTE PROCEDURE add_report_notification(); 

CREATE TRIGGER add_message_notification
    AFTER INSERT
    ON privateMessages
    FOR EACH ROW
EXECUTE PROCEDURE add_message_notification(); 

CREATE TRIGGER add_reminder_notification
    AFTER INSERT
    ON tasks
    FOR EACH ROW
EXECUTE PROCEDURE add_reminder_notification(); 

CREATE TRIGGER add_comment_notification
    AFTER INSERT
    ON taskComments
    FOR EACH ROW
EXECUTE PROCEDURE add_comment_notification(); 

CREATE TRIGGER update_users_search 
    BEFORE INSERT OR UPDATE 
    ON users
    FOR EACH ROW 
EXECUTE PROCEDURE users_search_update();

CREATE TRIGGER update_projects_search 
    BEFORE INSERT OR UPDATE
    ON projects
    FOR EACH ROW 
EXECUTE PROCEDURE projects_search_update();

CREATE TRIGGER update_tasks_search 
    BEFORE INSERT OR UPDATE
    ON tasks
    FOR EACH ROW 
EXECUTE PROCEDURE tasks_search_update();

CREATE TRIGGER add_project_user
    AFTER INSERT 
    ON invitations
    FOR EACH ROW
EXECUTE PROCEDURE add_project_user();

CREATE TRIGGER check_notification_type
    BEFORE INSERT 
    ON notifications
    FOR EACH ROW
EXECUTE PROCEDURE check_notification_type();

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
CREATE INDEX projects_index ON projects USING btree(created_at);  
CLUSTER projects USING projects_index;

--IDX03
CREATE INDEX project_user_by_user ON projectUsers USING btree(user_id);  
CLUSTER projectUsers USING project_user_by_user;

--IDX04
CREATE INDEX project_user_by_project ON projectUsers USING hash(project_id);

--IDX05
CREATE INDEX invitations_by_user ON invitations USING btree(project_id);  
CLUSTER invitations USING invitations_by_user;

--IDX06
CREATE INDEX favorite_projects_by_user ON favoriteProjects USING btree(user_id);  
CLUSTER favoriteProjects USING favorite_projects_by_user;

--IDX07
CREATE INDEX favorite_projects_by_project ON favoriteProjects USING hash(project_id);

--IDX08
CREATE INDEX project_messages_index ON projectMessages USING btree(user_id, project_id, created_at);  
CLUSTER projectMessages USING project_messages_index;

--IDX09
CREATE INDEX project_files_by_project ON projectFiles USING btree(project_id);  
CLUSTER projectFiles USING project_files_by_project;

--IDX10
CREATE INDEX reports_by_type ON reports USING hash(report_type);

--IDX11
CREATE INDEX reports_index ON reports USING btree(created_at);  
CLUSTER reports USING reports_index;

--IDX12
CREATE INDEX notifications_by_type ON notifications USING hash(notification_type);

--IDX13
CREATE INDEX notifications_index ON notifications USING btree(created_at);  
CLUSTER notifications USING notifications_index;

--IDX14
CREATE INDEX tasks_index ON tasks USING btree(project_id, due_date);  
CLUSTER tasks USING tasks_index;

--IDX15
CREATE INDEX users_assign_by_task ON userAssigns USING btree(task_id);  
CLUSTER userAssigns USING users_assign_by_task;

--IDX16
CREATE INDEX users_assign_by_user ON UserAssigns USING hash(user_id);

--IDX17
CREATE INDEX task_comments_index ON taskComments USING btree(task_id, created_at);  
CLUSTER taskComments USING task_comments_index;

--IDX18
CREATE INDEX search_user ON users USING GIN (search);

--IDX19
CREATE INDEX search_project ON projects USING GIN (search);

--IDX20
CREATE INDEX search_task ON tasks USING GIN (search);
