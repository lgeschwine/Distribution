<?php

namespace Claroline\SurveyBundle\Migrations\pdo_oci;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2014/08/08 03:15:43
 */
class Version20140808151542 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE claro_survey_resource (
                id NUMBER(10) NOT NULL, 
                published NUMBER(1) NOT NULL, 
                closed NUMBER(1) NOT NULL, 
                has_public_result NUMBER(1) NOT NULL, 
                allow_answer_edition NUMBER(1) NOT NULL, 
                start_date TIMESTAMP(0) DEFAULT NULL, 
                end_date TIMESTAMP(0) DEFAULT NULL, 
                resourceNode_id NUMBER(10) DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_SURVEY_RESOURCE' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_SURVEY_RESOURCE ADD CONSTRAINT CLARO_SURVEY_RESOURCE_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_SURVEY_RESOURCE_ID_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_SURVEY_RESOURCE_AI_PK BEFORE INSERT ON CLARO_SURVEY_RESOURCE FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_SURVEY_RESOURCE_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_SURVEY_RESOURCE_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_SURVEY_RESOURCE_ID_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_SURVEY_RESOURCE_ID_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_11B27D4BB87FAB32 ON claro_survey_resource (resourceNode_id)
        ");
        $this->addSql("
            CREATE TABLE claro_survey_questions_relation (
                survey_id NUMBER(10) NOT NULL, 
                question_id NUMBER(10) NOT NULL, 
                PRIMARY KEY(survey_id, question_id)
            )
        ");
        $this->addSql("
            CREATE INDEX IDX_C764C91BB3FE509D ON claro_survey_questions_relation (survey_id)
        ");
        $this->addSql("
            CREATE INDEX IDX_C764C91B1E27F6BF ON claro_survey_questions_relation (question_id)
        ");
        $this->addSql("
            CREATE TABLE claro_survey_choice (
                id NUMBER(10) NOT NULL, 
                choice_question_id NUMBER(10) NOT NULL, 
                content CLOB NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_SURVEY_CHOICE' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_SURVEY_CHOICE ADD CONSTRAINT CLARO_SURVEY_CHOICE_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_SURVEY_CHOICE_ID_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_SURVEY_CHOICE_AI_PK BEFORE INSERT ON CLARO_SURVEY_CHOICE FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_SURVEY_CHOICE_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_SURVEY_CHOICE_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_SURVEY_CHOICE_ID_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_SURVEY_CHOICE_ID_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_C49D43FEA46B3B4F ON claro_survey_choice (choice_question_id)
        ");
        $this->addSql("
            CREATE TABLE claro_survey_question (
                id NUMBER(10) NOT NULL, 
                workspace_id NUMBER(10) NOT NULL, 
                title CLOB NOT NULL, 
                question CLOB NOT NULL, 
                question_type VARCHAR2(255) NOT NULL, 
                comment_allowed NUMBER(1) NOT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_SURVEY_QUESTION' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_SURVEY_QUESTION ADD CONSTRAINT CLARO_SURVEY_QUESTION_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_SURVEY_QUESTION_ID_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_SURVEY_QUESTION_AI_PK BEFORE INSERT ON CLARO_SURVEY_QUESTION FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_SURVEY_QUESTION_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_SURVEY_QUESTION_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_SURVEY_QUESTION_ID_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_SURVEY_QUESTION_ID_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE INDEX IDX_1BD4C01382D40A1F ON claro_survey_question (workspace_id)
        ");
        $this->addSql("
            CREATE TABLE claro_survey_multiple_choice_question (
                id NUMBER(10) NOT NULL, 
                question_id NUMBER(10) DEFAULT NULL, 
                allow_multiple_response NUMBER(1) DEFAULT NULL, 
                PRIMARY KEY(id)
            )
        ");
        $this->addSql("
            DECLARE constraints_Count NUMBER; BEGIN 
            SELECT COUNT(CONSTRAINT_NAME) INTO constraints_Count 
            FROM USER_CONSTRAINTS 
            WHERE TABLE_NAME = 'CLARO_SURVEY_MULTIPLE_CHOICE_QUESTION' 
            AND CONSTRAINT_TYPE = 'P'; IF constraints_Count = 0 
            OR constraints_Count = '' THEN EXECUTE IMMEDIATE 'ALTER TABLE CLARO_SURVEY_MULTIPLE_CHOICE_QUESTION ADD CONSTRAINT CLARO_SURVEY_MULTIPLE_CHOICE_QUESTION_AI_PK PRIMARY KEY (ID)'; END IF; END;
        ");
        $this->addSql("
            CREATE SEQUENCE CLARO_SURVEY_MULTIPLE_CHOICE_QUESTION_ID_SEQ START WITH 1 MINVALUE 1 INCREMENT BY 1
        ");
        $this->addSql("
            CREATE TRIGGER CLARO_SURVEY_MULTIPLE_CHOICE_QUESTION_AI_PK BEFORE INSERT ON CLARO_SURVEY_MULTIPLE_CHOICE_QUESTION FOR EACH ROW DECLARE last_Sequence NUMBER; last_InsertID NUMBER; BEGIN 
            SELECT CLARO_SURVEY_MULTIPLE_CHOICE_QUESTION_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; IF (
                : NEW.ID IS NULL 
                OR : NEW.ID = 0
            ) THEN 
            SELECT CLARO_SURVEY_MULTIPLE_CHOICE_QUESTION_ID_SEQ.NEXTVAL INTO : NEW.ID 
            FROM DUAL; ELSE 
            SELECT NVL(Last_Number, 0) INTO last_Sequence 
            FROM User_Sequences 
            WHERE Sequence_Name = 'CLARO_SURVEY_MULTIPLE_CHOICE_QUESTION_ID_SEQ'; 
            SELECT : NEW.ID INTO last_InsertID 
            FROM DUAL; WHILE (last_InsertID > last_Sequence) LOOP 
            SELECT CLARO_SURVEY_MULTIPLE_CHOICE_QUESTION_ID_SEQ.NEXTVAL INTO last_Sequence 
            FROM DUAL; END LOOP; END IF; END;
        ");
        $this->addSql("
            CREATE UNIQUE INDEX UNIQ_388E4C251E27F6BF ON claro_survey_multiple_choice_question (question_id)
        ");
        $this->addSql("
            ALTER TABLE claro_survey_resource 
            ADD CONSTRAINT FK_11B27D4BB87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_survey_questions_relation 
            ADD CONSTRAINT FK_C764C91BB3FE509D FOREIGN KEY (survey_id) 
            REFERENCES claro_survey_resource (id)
        ");
        $this->addSql("
            ALTER TABLE claro_survey_questions_relation 
            ADD CONSTRAINT FK_C764C91B1E27F6BF FOREIGN KEY (question_id) 
            REFERENCES claro_survey_question (id)
        ");
        $this->addSql("
            ALTER TABLE claro_survey_choice 
            ADD CONSTRAINT FK_C49D43FEA46B3B4F FOREIGN KEY (choice_question_id) 
            REFERENCES claro_survey_multiple_choice_question (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_survey_question 
            ADD CONSTRAINT FK_1BD4C01382D40A1F FOREIGN KEY (workspace_id) 
            REFERENCES claro_workspace (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE claro_survey_multiple_choice_question 
            ADD CONSTRAINT FK_388E4C251E27F6BF FOREIGN KEY (question_id) 
            REFERENCES claro_survey_question (id) 
            ON DELETE CASCADE
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE claro_survey_questions_relation 
            DROP CONSTRAINT FK_C764C91BB3FE509D
        ");
        $this->addSql("
            ALTER TABLE claro_survey_questions_relation 
            DROP CONSTRAINT FK_C764C91B1E27F6BF
        ");
        $this->addSql("
            ALTER TABLE claro_survey_multiple_choice_question 
            DROP CONSTRAINT FK_388E4C251E27F6BF
        ");
        $this->addSql("
            ALTER TABLE claro_survey_choice 
            DROP CONSTRAINT FK_C49D43FEA46B3B4F
        ");
        $this->addSql("
            DROP TABLE claro_survey_resource
        ");
        $this->addSql("
            DROP TABLE claro_survey_questions_relation
        ");
        $this->addSql("
            DROP TABLE claro_survey_choice
        ");
        $this->addSql("
            DROP TABLE claro_survey_question
        ");
        $this->addSql("
            DROP TABLE claro_survey_multiple_choice_question
        ");
    }
}