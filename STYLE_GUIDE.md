# KASIR Style Guide - Tailwind CSS

Dokumentasi lengkap style dan pattern yang konsisten untuk semua halaman CRUD di aplikasi KASIR.

---

## 🎨 Color Scheme & Icon Associations

Setiap modul memiliki warna dan icon konsisten:

| Modul | Warna Primary | Icon | Penggunaan |
|-------|---------------|------|-----------|
| **Produk** | Blue (`blue-500/600`) | `fa-plus`, `fa-boxes`, `fa-tag` | Create: Blue, Edit: Yellow |
| **User** | Purple (`purple-500/600`) | `fa-user`, `fa-lock`, `fa-shield-alt` | Create: Purple, Edit: Orange |
| **Pelanggan** | Cyan (`cyan-500/600`) | `fa-user-circle`, `fa-map-marker-alt`, `fa-phone` | Create: Cyan, Edit: Cyan |
| **Laporan** | Indigo (`indigo-500/600`) | `fa-chart-bar`, `fa-calendar`, `fa-box` | Report: Indigo |

---

## 📋 Form Structure Pattern

### Full Page Form (Create/Edit)

```php
<div class="animate-fade-in">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i class="fas fa-[ICON] text-[COLOR]-600"></i> [TITLE]
            </h3>
            <p class="text-gray-500 mt-2">[SUBTITLE]</p>
        </div>
        <a href="<?php echo site_url('[MODULE]'); ?>" class="bg-white hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg border border-gray-300 transition-all duration-300 hover:shadow-md font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg mb-6 animate-fade-in flex justify-between items-center" role="alert">
            <span class="flex items-center gap-2"><i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?></span>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <form method="post" action="<?php echo site_url('[ACTION_URL]'); ?>" class="space-y-6">
            
            <!-- Form Fields -->
            <div>
                <label for="field_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-[ICON] text-[COLOR]-600 mr-1"></i> Field Label
                </label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[COLOR]-500 focus:border-transparent transition-all duration-300" id="field_id" name="field_name" placeholder="Placeholder text" required>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200 pt-6"></div>

            <!-- Form Actions -->
            <div class="flex gap-3 justify-end">
                <a href="<?php echo site_url('[MODULE]'); ?>" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-300 hover:shadow-md">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-[COLOR]-500 to-[COLOR]-600 hover:from-[COLOR]-600 hover:to-[COLOR]-700 text-white font-medium rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> [ACTION BUTTON TEXT]
                </button>
            </div>
        </form>
    </div>
</div>
```

### Form Input Types

#### Text Input
```php
<div>
    <label for="field_id" class="block text-sm font-semibold text-gray-700 mb-2">
        <i class="fas fa-[ICON] text-[COLOR]-600 mr-1"></i> Label
    </label>
    <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[COLOR]-500 focus:border-transparent transition-all duration-300" id="field_id" name="field_name" placeholder="Placeholder" required>
</div>
```

#### Number Input (dengan prefix)
```php
<div>
    <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
        <i class="fas fa-money-bill-wave text-green-600 mr-1"></i> Harga (Rp)
    </label>
    <div class="relative">
        <span class="absolute left-4 top-3.5 text-gray-500 font-semibold">Rp</span>
        <input type="number" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300" id="harga" name="harga" placeholder="0" min="0" step="1" required>
    </div>
</div>
```

#### Textarea
```php
<div>
    <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
        <i class="fas fa-map-marker-alt text-orange-600 mr-1"></i> Alamat
    </label>
    <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300 resize-none" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat"></textarea>
</div>
```

#### Select Dropdown
```php
<div>
    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
        <i class="fas fa-shield-alt text-indigo-600 mr-1"></i> Role / Jabatan
    </label>
    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white" id="role" name="role" required>
        <option value="">Pilih Role</option>
        <option value="admin">Admin</option>
        <option value="petugas">Petugas</option>
    </select>
</div>
```

---

## 🔍 Modal / Detail Views Pattern

### Detail Modal (untuk Show/View)
```php
<div class="space-y-6">
    <!-- Section with Border -->
    <div class="border-b border-gray-200 pb-4">
        <label class="block text-sm font-semibold text-gray-600 mb-2">
            <i class="fas fa-[ICON] text-[COLOR]-600 mr-2"></i>Label
        </label>
        <p class="text-xl font-bold text-gray-900"><?php echo $data->field; ?></p>
    </div>

    <!-- Gradient Card Section -->
    <div class="bg-gradient-to-br from-[COLOR]-50 to-[COLOR]-100 p-4 rounded-lg border border-[COLOR]-200">
        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
            <i class="fas fa-[ICON] text-[COLOR]-600 mr-1"></i>Label
        </label>
        <p class="text-lg font-bold text-[COLOR]-600"><?php echo $data->field; ?></p>
    </div>

    <!-- Info Alert -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <i class="fas fa-info-circle text-blue-600 mt-1 flex-shrink-0"></i>
            <div class="text-sm text-gray-700">
                <p class="font-semibold text-blue-900 mb-1">Informasi</p>
                <p class="text-blue-800">Additional information text here.</p>
            </div>
        </div>
    </div>
</div>
```

### Edit Modal Form
```php
<form id="editForm" class="space-y-5">
    <!-- Field -->
    <div>
        <label for="field_id" class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-[ICON] text-[COLOR]-600 mr-1"></i> Label
        </label>
        <input type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[COLOR]-500 focus:border-transparent transition-all duration-300" id="field_id" name="field_name" value="<?php echo $data->field; ?>" placeholder="Placeholder" required>
    </div>
    
    <!-- Info Alert -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
        <p class="text-xs text-blue-800 flex items-start gap-2">
            <i class="fas fa-info-circle flex-shrink-0 mt-0.5"></i>
            <span><strong>Catatan:</strong> Klik tombol Simpan di bawah untuk menyimpan perubahan.</span>
        </p>
    </div>
</form>

<script>
    let editItemID = <?php echo $data->id; ?>;
</script>
```

---

## 📊 Detail Card Pattern (untuk Report/Laporan)

```php
<div class="space-y-6">
    <!-- Header Card dengan Grid -->
    <div class="bg-gradient-to-r from-[COLOR]-50 to-[COLOR]-100 border border-[COLOR]-200 rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                    <i class="fas fa-calendar text-[COLOR]-600 mr-1"></i>Tanggal
                </label>
                <p class="text-lg font-bold text-gray-900"><?php echo $data->tanggal; ?></p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                    <i class="fas fa-money-bill-wave text-green-600 mr-1"></i>Total
                </label>
                <p class="text-lg font-bold text-green-600">Rp <?php echo number_format($data->total, 0, ',', '.'); ?></p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">
                    <i class="fas fa-user-circle text-purple-600 mr-1"></i>Pelanggan
                </label>
                <p class="text-lg font-bold text-gray-900"><?php echo $data->customer; ?></p>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div>
        <h6 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-box text-yellow-600"></i>Detail Items
        </h6>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-center">Harga</th>
                        <th class="px-4 py-3 text-center">Jumlah</th>
                        <th class="px-4 py-3 text-right pr-4">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <!-- Row Template -->
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 py-3 font-medium text-gray-900">Item Name</td>
                        <td class="px-4 py-3 text-center">Rp 10.000</td>
                        <td class="px-4 py-3 text-center font-semibold">5</td>
                        <td class="px-4 py-3 text-right font-bold text-green-600">Rp 50.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
```

---

## 🎯 Button Patterns

### Primary Action Button (Create/Save)
```html
<button type="submit" class="px-6 py-3 bg-gradient-to-r from-[COLOR]-500 to-[COLOR]-600 hover:from-[COLOR]-600 hover:to-[COLOR]-700 text-white font-medium rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
    <i class="fas fa-save mr-2"></i> [Action Text]
</button>
```

### Secondary Action Button (Cancel)
```html
<a href="<?php echo site_url('[MODULE]'); ?>" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-300 hover:shadow-md">
    <i class="fas fa-times mr-2"></i> Batal
</a>
```

### Icon Only Button (Row Actions)
```html
<button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-sm transition-all duration-300 hover:shadow-md" title="Aksi">
    <i class="fas fa-eye"></i>
</button>
```

---

## ⚠️ Alert/Message Patterns

### Error Alert
```php
<?php if ($this->session->flashdata('error')): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg mb-6 animate-fade-in flex justify-between items-center" role="alert">
        <span class="flex items-center gap-2">
            <i class="fas fa-exclamation-circle"></i> 
            <?php echo $this->session->flashdata('error'); ?>
        </span>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">&times;</button>
    </div>
<?php endif; ?>
```

### Success Alert
```php
<?php if ($this->session->flashdata('success')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 animate-fade-in flex justify-between items-center">
        <span><i class="fas fa-check-circle mr-2"></i> <?php echo $this->session->flashdata('success'); ?></span>
        <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">&times;</button>
    </div>
<?php endif; ?>
```

### Info Box
```html
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex items-start gap-3">
        <i class="fas fa-info-circle text-blue-600 mt-1 flex-shrink-0"></i>
        <div class="text-sm text-gray-700">
            <p class="font-semibold text-blue-900 mb-1">Judul Informasi</p>
            <p class="text-blue-800">Teks informasi lengkap.</p>
        </div>
    </div>
</div>
```

---

## 📱 Responsive Grid Pattern

### 2-Column Grid
```html
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div><!-- Column 1 --></div>
    <div><!-- Column 2 --></div>
</div>
```

### 3-Column Grid
```html
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div><!-- Column 1 --></div>
    <div><!-- Column 2 --></div>
    <div><!-- Column 3 --></div>
</div>
```

---

## 🎨 Tailwind Classes Quick Reference

### Text & Typography
- `text-3xl font-bold` - Main headings
- `text-lg font-bold` - Sub headings
- `text-sm font-semibold` - Labels
- `text-xs font-semibold uppercase tracking-wider` - Small labels
- `text-gray-500` - Muted text
- `text-gray-900` - Dark text (default)

### Spacing
- `mb-6` / `mt-6` - Major sections (24px)
- `mb-4` / `mt-4` - Medium spacing (16px)
- `mb-2` / `mt-2` - Small spacing (8px)
- `p-8` - Large padding
- `p-4` - Medium padding
- `p-3` - Small padding
- `gap-3` / `gap-4` / `gap-6` - Grid gaps

### Colors (Consistent)
- Blue: `bg-blue-500`, `text-blue-600`, `ring-blue-500`
- Purple: `bg-purple-500`, `text-purple-600`, `ring-purple-500`
- Cyan: `bg-cyan-500`, `text-cyan-600`, `ring-cyan-500`
- Green: `bg-green-500`, `text-green-600`, `ring-green-500`
- Orange: `bg-orange-500`, `text-orange-600`, `ring-orange-500`
- Red: `bg-red-500`, `text-red-600`, `ring-red-500`

### Border & Shadow
- `border border-gray-300` - Light border
- `rounded-lg` - Standard border radius
- `rounded-xl` - Larger border radius (for cards)
- `shadow-lg` - Standard shadow
- `shadow-md` - Medium shadow

### Focus States
- `focus:outline-none focus:ring-2 focus:ring-[COLOR]-500 focus:border-transparent`

### Hover & Transitions
- `hover:bg-gray-50` - Light hover effect
- `hover:shadow-lg` - Shadow on hover
- `hover:-translate-y-0.5` - Lift effect
- `transition-all duration-300` - Smooth transition

---

## 🔄 Animation Classes

```css
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

@keyframes slideIn {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(0); }
}
```

Usage: `animate-fade-in`, `animate-slide-in`

---

## ✅ Checklist untuk Membuat CRUD Page Baru

- [ ] Gunakan warna konsisten untuk modul (lihat Color Scheme)
- [ ] Gunakan icon yang sesuai untuk setiap field
- [ ] Apply "Full Page Form Pattern" untuk create/edit
- [ ] Apply "Detail Modal Pattern" untuk show
- [ ] Gunakan consistent button styling
- [ ] Include alert messages dengan format yang benar
- [ ] Ensure responsive design (md breakpoint)
- [ ] Test focus states dan transitions
- [ ] Verify spacing consistency (use gap/margin mulai dari mb-2)

---

Dibuat untuk menjaga konsistensi styling di seluruh aplikasi KASIR.
