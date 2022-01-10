SET search_path TO lbaw2181;

DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS reports;

DROP TYPE IF EXISTS notificationType;
DROP TYPE IF EXISTS reportState;

ALTER TABLE users ADD is_banned boolean NOT NULL DEFAULT false;

CREATE TYPE notificationType AS ENUM (
    'INVITE',
    'FORUM',
    'REPORT',
    'MESSAGE',
    'REMINDER',
    'COMMENT',
    'CHANGE_MANAGER',
    'ASSIGN',
    'COMPLETE_TASK'
);

CREATE TYPE reportState AS ENUM (
    'PENDING',
    'IGNORED',
    'DONE'
);

CREATE TABLE reports
(
    id serial,
    user_id integer NOT NULL,
    text varchar NOT NULL,
    report_type reportType NOT NULL,
    created_at timestamp NOT NULL,
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
    CONSTRAINT report_state_ck CHECK (report_state = ANY (ARRAY['PENDING'::reportState, 'IGNORED'::reportState, 'DONE'::reportState]))
);

CREATE TABLE notifications --povoar
(
    id serial,
    notification_type notificationType NOT NULL,
    created_at timestamp NOT NULL,
    user_id integer NOT NULL,
    invitation_user_id integer,
    project_message_id integer,
    report_id integer,
    private_message_id integer,
    task_id integer,
    task_comment_id integer,
    invitation_project_id integer,
    seen boolean NOT NULL DEFAULT false,
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
    CONSTRAINT notification_type_ck CHECK (notification_type = ANY (ARRAY['INVITE'::notificationType, 'FORUM'::notificationType, 'REPORT'::notificationType, 'MESSAGE'::notificationType, 'REMINDER'::notificationType, 'COMMENT'::notificationType,'CHANGE_MANAGER'::notificationType,'ASSIGN'::notificationType,'COMPLETE_TASK'::notificationType]))
);

CREATE OR REPLACE FUNCTION check_notification_type() RETURNS TRIGGER AS
              $BODY$
BEGIN
    if
        (new.notification_type = 'INVITE' and new.invitation_project_id IS NOT NULL and new.invitation_user_id IS NOT NULL and new.project_message_id IS NULL and new.report_id IS NULL and new.private_message_id IS NULL and new.task_id IS NULL and new.task_comment_id IS NULL)
    then

    elsif
        (new.project_message_id IS NOT NULL and new.notification_type = 'FORUM' and new.invitation_user_id IS NULL and new.invitation_project_id IS NULL and new.report_id IS NULL and new.private_message_id IS NULL and new.task_id IS NULL and new.task_comment_id IS NULL)
    then

	elsif
        (new.project_message_id IS NULL and new.notification_type = 'REPORT' and new.invitation_user_id IS NULL and new.invitation_project_id IS NULL and new.report_id IS NOT NULL and new.private_message_id IS NULL and new.task_id IS NULL and new.task_comment_id IS NULL)
    then

	elsif
        (new.project_message_id IS NULL and new.notification_type = 'MESSAGE' and new.invitation_user_id IS NULL and new.invitation_project_id IS NULL and new.report_id IS NULL and new.private_message_id IS NOT NULL and new.task_id IS NULL and new.task_comment_id IS NULL)
    then

    elsif
        (new.project_message_id IS NULL and new.notification_type = 'REMINDER' and new.invitation_user_id IS NULL and new.invitation_project_id IS NULL and new.report_id IS NULL and new.private_message_id IS NULL and new.task_id IS NOT NULL and new.task_comment_id IS NULL)
    then

	elsif
        (new.project_message_id IS NULL and new.notification_type = 'COMMENT' and new.invitation_user_id IS NULL and new.invitation_project_id IS NULL and new.report_id IS NULL and new.private_message_id IS NULL and new.task_id IS NULL and new.task_comment_id IS NOT NULL)
    then

    elsif
        (new.notification_type = 'CHANGE_MANAGER' and new.invitation_project_id IS NOT NULL and new.invitation_user_id IS NULL and new.project_message_id IS NULL and new.report_id IS NULL and new.private_message_id IS NULL and new.task_id IS NULL and new.task_comment_id IS NULL)
    then

    elsif
        (new.notification_type = 'ASSIGN' and new.invitation_project_id IS NULL and new.invitation_user_id IS NULL and new.project_message_id IS NULL and new.report_id IS NULL and new.private_message_id IS NULL and new.task_id IS NOT NULL and new.task_comment_id IS NULL)
    then

    elsif
        (new.notification_type = 'COMPLETE_TASK' and new.invitation_project_id IS NULL and new.invitation_user_id IS NULL and new.project_message_id IS NULL and new.report_id IS NULL and new.private_message_id IS NULL and new.task_id IS NOT NULL and new.task_comment_id IS NULL)
    then
    else
        delete from notifications where id = new.id;
    end if;
    RETURN NEW;
    END;
$BODY$
    LANGUAGE plpgsql;