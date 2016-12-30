
-- 用户表
CREATE TABLE relax_user(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  sex TEXT NOT NULL DEFAULT '男',
  age INTEGER DEFAULT 0,
  portrait TEXT,
  created_at INT(11) NOT NULL DEFAULT 0,
  updated_at INT(11) NOT NULL DEFAULT 0,
  level INTEGER DEFAULT 1,
  activity INTEGER DEFAULT 0,
  height DOUBLE DEFAULT 0,
  weight DOUBLE DEFAULT 0,
  isAdmin INTEGER DEFAULT 0
);

-- 活动表
CREATE TABLE relax_activity(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR(50) NOT NULL,
  time INT(11) NOT NULL,
  address TEXT NOT NULL,
  detail TEXT NOT NULL,
  picture TEXT DEFAULT 0,
  peopleLimit INTEGER NOT NULL,
  peopleSign INTEGER DEFAULT 0,
  sponsorId INTEGER NOT NULL,
  created_at INT(11) NOT NULL DEFAULT 0,
  updated_at INT(11) NOT NULL DEFAULT 0
);

-- 活动参与表
CREATE TABLE relax_activity_attend(
  activityId INTEGER NOT NULL,
  userId INTEGER NOT NULL,
  PRIMARY KEY (activityId,userId)
);

-- 用户运动数据表
CREATE TABLE relax_sport(
  userId INTEGER NOT NULL,
  startTime INT(11) NOT NULL,
  endTime INT(11) NOT NULL,
  date TEXT NOT NULL,
  distance INTEGER NOT NULL,
  heat INTEGER NOT NULL,
  PRIMARY KEY (userId,startTime,endTime)
);

-- 用户关注表
CREATE TABLE relax_friend(
  userId INTEGER NOT NULL REFERENCES relax_user(id) ON DELETE CASCADE,
  friendId INTEGER DEFAULT NULL REFERENCES relax_user(id) ON DELETE SET NULL,
  PRIMARY KEY (userId,friendId)
);

-- 动态表
CREATE TABLE relax_blog(
  blogId INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  userId INTEGER NOT NULL REFERENCES relax_user(id) ON DELETE CASCADE,
  created_at INT(11) NOT NULL DEFAULT 0,
  updated_at INT(11) NOT NULL DEFAULT 0,
  content TEXT NOT NULL,
  picture TEXT DEFAULT 0
);

-- 评论表
CREATE TABLE relax_comment(
  commentId INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  blogId INTEGER NOT NULL REFERENCES relax_blog(blogId) ON DELETE CASCADE,
  userId INTEGER NOT NULL REFERENCES relax_user(id) ON DELETE CASCADE,
  created_at INT(11) NOT NULL DEFAULT 0,
  updated_at INT(11) NOT NULL DEFAULT 0,
  content TEXT NOT NULL
);

-- 点赞表
CREATE TABLE relax_praise(
  blogId INTEGER NOT NULL REFERENCES relax_blog(blogId) ON DELETE CASCADE,
  userId INTEGER NOT NULL REFERENCES relax_user(id) ON DELETE CASCADE,
  created_at INT(11) NOT NULL DEFAULT 0,
  updated_at INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY(blogId,userId)
);

-- 未读消息表
CREATE TABLE relax_info(
  userId INTEGER NOT NULL REFERENCES relax_user(id) ON DELETE CASCADE,
  time INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY(userId,time)
);