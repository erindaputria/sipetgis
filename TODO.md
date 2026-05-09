# Fix Data Kepemilikan & History Ternak Filters/Issues

## Status: 🔄 In Progress

### 1. data_kepemilikan Fixes [✅ Complete]

- [ ] Update model queries: WHERE LOWER(TRIM(jenis_usaha)) LIKE '%?%'
- [x] Controller: trim(strtolower(urldecode(post('jenis_usaha'))))
- [x] Detail response: Include total_peternak COUNT(DISTINCT nik)

### 2. data_history_ternak Fixes [✅ Complete]

- [ ] JS filter: Change exact === to toLowerCase().includes()
- [ ] Add console.error logging for edit/delete AJAX
- [x] JS fixes complete (fuzzy filter + error logging). CSRF check: Controller POST direct, no CSRF visible in config - likely disabled.

### 3. Testing [ ]

- [ ] Test data_kepemilikan filter \"peternak kambing\" → results + count match
- [ ] Test detail → shows COUNT(DISTINCT nik)
- [ ] Test history_ternak filter komoditas/periode
- [ ] Test edit/delete → success + reload

### 4. Completion [ ]

- [ ] attempt_completion with test commands
