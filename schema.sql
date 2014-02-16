CREATE TABLE IF NOT EXISTS tbl_status (
  id              VARCHAR(10),
  posted_date     DATE,
  owner_id        VARCHAR(10),
  text            VARCHAR(140)
)

CREATE TABLE IF NOT EXISTS tbl_users (
  id              VARCHAR(10),
  username        VARCHAR(30),
  password        VARCHAR(60)
)