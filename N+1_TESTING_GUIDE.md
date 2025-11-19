# 🧪 N+1 Query Fixes - Testing Guide
## Web Profil Desa Warurejo

**Date:** November 17, 2025  
**Purpose:** Verify all N+1 query fixes are working correctly

---

## 🛠️ Setup for Testing

### 1. Enable Laravel Debugbar

**Already Installed:** ✅ `barryvdh/laravel-debugbar`

**Enable in .env:**
```env
APP_DEBUG=true
DEBUGBAR_ENABLED=true
```

**Restart Server:**
```bash
# Stop current server (Ctrl+C)
php artisan serve

# Or if using XAMPP, just refresh the page
```

### 2. Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## ✅ Test 1: Homepage (Public)

### What to Test
The homepage loads berita, galeri, and potensi data.

### Steps
1. Open browser: `http://localhost/WebDesaWarurejo/public`
2. Look at bottom of page for Debugbar
3. Click on "Queries" tab

### Expected Results

**Query Count: ~6 queries**
```
✅ Query 1: SELECT * FROM profil_desa
✅ Query 2: SELECT * FROM berita WHERE status = 'published' LIMIT 6
✅ Query 3: SELECT * FROM admins WHERE id IN (1,2,3,4,5,6)
✅ Query 4: SELECT * FROM potensi_desa WHERE is_active = 1 LIMIT 6
✅ Query 5: SELECT * FROM galeri WHERE is_active = 1 LIMIT 4
✅ Query 6: SELECT * FROM admins WHERE id IN (...)
```

**What You Should NOT See:**
```
❌ SELECT * FROM admins WHERE id = 1
❌ SELECT * FROM admins WHERE id = 2
❌ SELECT * FROM admins WHERE id = 3
(Multiple similar queries = N+1 problem)
```

### How to Verify
- Total queries: Should be **< 10**
- No duplicate admin queries
- All admin data loaded in 1-2 queries max

---

## ✅ Test 2: Berita List Page (Public)

### What to Test
List of all published berita with pagination.

### Steps
1. Navigate to: `http://localhost/WebDesaWarurejo/public/berita`
2. Check Debugbar "Queries" tab
3. Note the total query count

### Expected Results

**Query Count: 2-3 queries**
```
✅ Query 1: SELECT * FROM berita WHERE status = 'published' ORDER BY...
✅ Query 2: SELECT * FROM admins WHERE id IN (1,2,3,...)
✅ Query 3: SELECT COUNT(*) FROM berita (for pagination)
```

**If You Have 100 Berita:**
- Before fix: **101 queries** (1 + 100) ❌
- After fix: **2-3 queries** ✅

### How to Verify
- Total queries: Should be **< 5**
- Only ONE admin query (using WHERE id IN)
- Admin names display correctly

---

## ✅ Test 3: Berita Detail Page (Public)

### What to Test
Single berita page with related articles.

### Steps
1. Click on any berita from list
2. Check Debugbar "Queries" tab

### Expected Results

**Query Count: 4-5 queries**
```
✅ Query 1: SELECT * FROM berita WHERE slug = '...'
✅ Query 2: SELECT * FROM admins WHERE id = 1
✅ Query 3: UPDATE berita SET views = views + 1
✅ Query 4: SELECT * FROM berita (related articles)
✅ Query 5: SELECT * FROM admins WHERE id IN (...)
```

### How to Verify
- Total queries: Should be **< 8**
- Views counter increments
- Related articles show correctly

---

## ✅ Test 4: Galeri List Page (Public)

### What to Test
Gallery page with images and admin info.

### Steps
1. Navigate to: `http://localhost/WebDesaWarurejo/public/galeri`
2. Check Debugbar "Queries" tab

### Expected Results

**Query Count: 2-3 queries**
```
✅ Query 1: SELECT * FROM galeri WHERE is_active = 1 ORDER BY...
✅ Query 2: SELECT * FROM admins WHERE id IN (1,2,3,...)
✅ Query 3: SELECT COUNT(*) FROM galeri (for pagination)
```

**If You Have 50 Galeri:**
- Before fix: **51 queries** (1 + 50) ❌
- After fix: **2-3 queries** ✅

### How to Verify
- Total queries: Should be **< 5**
- Only ONE admin query
- Admin info displays correctly on each galeri item

---

## ✅ Test 5: Admin Dashboard

### What to Test
Admin dashboard with recent berita and statistics.

### Steps
1. Login to admin: `http://localhost/WebDesaWarurejo/public/admin/login`
2. View dashboard
3. Check Debugbar "Queries" tab

### Expected Results

**Query Count: 3-5 queries**
```
✅ Query 1: SELECT COUNT(*) FROM berita
✅ Query 2: SELECT COUNT(*) FROM potensi_desa
✅ Query 3: SELECT COUNT(*) FROM galeri
✅ Query 4: SELECT * FROM berita ORDER BY created_at LIMIT 5
✅ Query 5: SELECT * FROM admins WHERE id IN (...)
✅ Query 6-7: Visitor statistics queries
```

### How to Verify
- Total queries: Should be **< 10**
- Recent berita loads with admin info
- No duplicate admin queries

---

## ✅ Test 6: Admin Berita List

### What to Test
Admin berita management page.

### Steps
1. Navigate to: `http://localhost/WebDesaWarurejo/public/admin/berita`
2. Check Debugbar "Queries" tab

### Expected Results

**Query Count: 2-3 queries**
```
✅ Query 1: SELECT * FROM berita ORDER BY created_at DESC
✅ Query 2: SELECT * FROM admins WHERE id IN (...)
✅ Query 3: SELECT COUNT(*) FROM berita (for pagination)
```

### How to Verify
- Total queries: Should be **< 5**
- Only ONE admin query
- All berita display with author names

---

## ✅ Test 7: Admin Galeri List

### What to Test
Admin galeri management page.

### Steps
1. Navigate to: `http://localhost/WebDesaWarurejo/public/admin/galeri`
2. Check Debugbar "Queries" tab

### Expected Results

**Query Count: 2 queries**
```
✅ Query 1: SELECT * FROM galeri ORDER BY created_at DESC
✅ Query 2: SELECT * FROM admins WHERE id IN (...)
```

**This was FIXED today!**
- Before fix: Direct `Galeri::latest()->get()` caused N+1 ❌
- After fix: `Galeri::with('admin')->latest()->get()` ✅

### How to Verify
- Total queries: Should be **2-3**
- Only ONE admin query
- Admin info displays for each galeri

---

## 🔍 What to Look For

### ✅ Good Patterns (Eager Loading)

```sql
-- Single query for all admins
SELECT * FROM admins WHERE id IN (1, 2, 3, 4, 5, 6, 7, 8)
```

### ❌ Bad Patterns (N+1 Problem)

```sql
-- Multiple queries for same thing
SELECT * FROM admins WHERE id = 1
SELECT * FROM admins WHERE id = 2
SELECT * FROM admins WHERE id = 3
SELECT * FROM admins WHERE id = 4
(This pattern indicates N+1 problem!)
```

---

## 📊 Benchmark Comparison

Create a simple test with data:

### Test with Sample Data

**Seed Test Data:**
```bash
# Create 100 test berita
php artisan tinker
>>> App\Models\Berita::factory()->count(100)->create(['status' => 'published'])
```

**Then Test:**
1. Visit berita list page
2. Check query count

**Expected:**
- 100 berita = **2-3 queries** ✅
- Not 101 queries ❌

---

## 🎯 Performance Checklist

Mark each test as complete:

- [ ] **Test 1:** Homepage (< 10 queries)
- [ ] **Test 2:** Berita List (< 5 queries)
- [ ] **Test 3:** Berita Detail (< 8 queries)
- [ ] **Test 4:** Galeri List (< 5 queries)
- [ ] **Test 5:** Admin Dashboard (< 10 queries)
- [ ] **Test 6:** Admin Berita List (< 5 queries)
- [ ] **Test 7:** Admin Galeri List (< 3 queries)

**All tests pass:** ✅ N+1 queries fixed successfully!

---

## 🐛 Troubleshooting

### Issue: Debugbar Not Showing

**Solution:**
```bash
# Clear config cache
php artisan config:clear

# Make sure in .env
APP_DEBUG=true
DEBUGBAR_ENABLED=true

# Restart server
```

### Issue: Still Seeing Many Queries

**Check:**
1. Are you logged in as admin? (Admin queries add more)
2. Is cache enabled? (Clear it: `php artisan cache:clear`)
3. Are there other relationships being accessed?

**Debug:**
```php
// Add to controller temporarily
DB::enableQueryLog();
// your code
dd(DB::getQueryLog());
```

### Issue: Admin Info Not Showing

**Check:**
1. Verify relationship exists in model: `public function admin()`
2. Verify data exists in database
3. Check blade view uses: `{{ $item->admin->nama }}` not `{{ $item->admin_id }}`

---

## 📝 Testing Report Template

After testing, document your findings:

```markdown
## N+1 Query Testing Report

**Date:** [Date]
**Tester:** [Your Name]

### Test Results

| Page | Query Count | Status | Notes |
|------|-------------|--------|-------|
| Homepage | X queries | ✅/❌ | |
| Berita List | X queries | ✅/❌ | |
| Berita Detail | X queries | ✅/❌ | |
| Galeri List | X queries | ✅/❌ | |
| Admin Dashboard | X queries | ✅/❌ | |
| Admin Berita | X queries | ✅/❌ | |
| Admin Galeri | X queries | ✅/❌ | |

### Performance Summary
- Average query reduction: X%
- Average page load improvement: X%
- Issues found: X

### Recommendations
- [Any additional optimizations]
```

---

## 🚀 Next Steps After Testing

If all tests pass:
1. ✅ Mark "Fix N+1 Query Issues" as complete
2. ✅ Document performance improvements
3. ✅ Move to next Week 4 task (Testing Implementation)

If issues found:
1. Review specific failing pages
2. Check repository methods for missing `->with()`
3. Verify relationships in models
4. Re-test after fixes

---

## 📚 Additional Resources

### Laravel Debugbar Tabs

1. **Queries Tab** - Shows all database queries
2. **Timeline** - Shows execution time
3. **Memory** - Shows memory usage
4. **Route** - Shows current route info

### Useful Commands

```bash
# Clear all caches
php artisan optimize:clear

# Check routes
php artisan route:list

# Check model relationships
php artisan tinker
>>> App\Models\Berita::with('admin')->first()
```

---

**Testing Status:** Ready for verification  
**Expected Time:** 15-20 minutes for all tests  
**Difficulty:** Easy (just observe Debugbar)

**🧪 Happy Testing! Let's verify our optimization works! 🎉**
