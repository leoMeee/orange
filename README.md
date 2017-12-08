# orange
php framework



# 计划

- [x] 入口文件 index.php
- [x] 框架核心文件目录
  - [x] class autoload
  - [x] 路由转发
  - [x] 模板
  - [x] model
  - [x] config
    - [x] set config
    - [x] load config
    - [x] get config

- [x] 应用目录 app
- [x] controller目录
- [x] composer
   - [x] var-dumper
   - [x] whoops
   - [ ] dot_env
   - [x] Medoo
   - [ ] twig
- [x] db query
    - [x] select
    - [x] insert
    - [x] update
    - [x] delete
    - [x] get
    - [x] count
    - [ ] limit
    - [ ] order
    - [ ] join
    - [x] 事务
    - [ ] 复杂查询
        - [ ] in 或 not in
        - [ ] like
        - [ ] 大于 或 小于
        - [ ] between
- [ ] ORM
- [ ] Cache

## bug
- [ ] 插入数据库中文乱码
- [ ] var_dump 时页面请求两次