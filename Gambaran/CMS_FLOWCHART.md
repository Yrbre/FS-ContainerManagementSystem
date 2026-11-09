# CTC · Container Management System — Flowchart

Flowchart sistem `baracoal-cms` (Laravel 8 + SQL Server), disusun dari source code pada 4 November 2026.
Diagram memakai **Mermaid**, jadi bisa dibuka langsung di GitHub/GitLab, VS Code (ekstensi *Markdown Preview Mermaid Support*), Obsidian, atau mermaid.live.

Pendamping dokumen: `CMS_SYSTEM_OVERVIEW.png` (poster) dan `CMS_SYSTEM_GUIDE.pdf` (panduan lengkap).

**Singkatan path:**
`C/` = `app/Http/Controllers/Console/` · `R/` = `app/Repositories/Console/` · `L/` = `app/Http/Livewire/` · `M/` = `app/Models/`

## Daftar isi

1. [Arsitektur sistem](#1-arsitektur-sistem)
2. [Alur request (login → role → proses)](#2-alur-request)
3. [Alur proses end-to-end](#3-alur-proses-end-to-end)
4. [Status container (state diagram)](#4-status-container)
5. [Pola status transaksi](#5-pola-status-transaksi)
6. [BP-02 Aktivitas harian](#6-bp-02-aktivitas-harian)
7. [BP-03 Inspeksi](#7-bp-03-inspeksi)
8. [BP-04 BAST ke Vendor (BAST 1)](#8-bp-04-bast-ke-vendor-bast-1)
9. [BP-05 Progress perbaikan](#9-bp-05-progress-perbaikan)
10. [BP-06 BAST dari Vendor (BAST 2) & garansi](#10-bp-06-bast-dari-vendor-bast-2--garansi)
11. [BP-07 Scrap](#11-bp-07-scrap)
12. [Notifikasi email & WhatsApp](#12-notifikasi-email--whatsapp)
13. [Dashboard & cek layanan WhatsApp](#13-dashboard--cek-layanan-whatsapp)
14. [Deploy](#14-deploy)
15. [Ringkasan file per proses](#15-ringkasan-file-per-proses)

---

## 1. Arsitektur sistem

```mermaid
flowchart LR
    U["Browser user<br/>8 role"] -->|"/console/*"| RT

    subgraph APP["CTC Web · Laravel 8 · PHP 8.1 · 172.16.10.28"]
        RT["routes/admin.php<br/>auth:admin + role:"] --> CT["Controller<br/>C/*Controller"]
        CT --> RP["Repository<br/>R/*Repository<br/>logika bisnis"]
        LW["Livewire<br/>L/* form detail"] --> MD
        RP --> MD["Model Eloquent<br/>M/*"]
        RP --> ML["Mail<br/>15 Mailable"]
        RP --> WS["WhatspieService"]
        LW --> ST["Storage public<br/>foto & dokumen"]
    end

    MD --> DB[("SQL Server<br/>tabel + view v_ct_*")]
    ML --> SMTP["SMTP server<br/>MAIL_* .env"]
    WS --> WA["WA gateway<br/>172.16.10.114:3000"]
```

## 2. Alur request

```mermaid
flowchart TD
    A(["User buka /"]) --> B["Redirect ke /console/login<br/>routes/web.php"]
    B --> C["Isi username + password"]
    C --> D{"Auth::guard admin<br/>attempt berhasil?<br/>C/Auth/LoginController.php:31"}
    D -- Tidak --> C
    D -- Ya --> E["Dashboard"]
    E --> F["Pilih menu → request /console/..."]
    F --> G{"Middleware auth:admin<br/>sudah login?"}
    G -- Tidak --> B
    G -- Ya --> H{"RoleMiddleware<br/>role cocok?<br/>Admin::hasRole()"}
    H -- "Tidak" --> I["HTTP 403"]
    H -- "Ya / Administrator" --> J["Controller"]
    J --> K["Repository:<br/>DB::beginTransaction"]
    K --> L["Ubah status transaksi<br/>+ status container"]
    L --> M["Kirim email / WA"]
    M --> N["DB::commit"]
    N --> O["Redirect + flash message"]
```

> Administrator selalu lolos cek role (`M/Admin.php:50`). Beberapa route **tidak** punya middleware `role` (Lokasi selain index, Report, hapus detail inspeksi, update progress BAST 2).

## 3. Alur proses end-to-end

```mermaid
flowchart TD
    S(["CT beroperasi · status O"]) --> A1["1. Aktivitas Harian<br/>Turun Container<br/>CT → TSO / SO di BJI-BBA"]
    A1 --> A2["2. Inspeksi<br/>Checker POST → CT TSO/TSOI<br/>email Supervisor + WA grup"]
    A2 --> A3{"Supervisor approve?<br/>jenis perbaikan + root cause"}
    A3 -- Reject --> A2
    A3 -- Approve --> D{"Layak diperbaiki?"}
    D -- Tidak --> SC["7. Scrap<br/>Supervisor POST → Manager approve<br/>CT → S"]
    SC --> E1(["Selesai · CT Scrap"])
    D -- Ya --> B1["3. BAST ke Vendor / BAST 1<br/>Checker POST"]
    B1 --> B2{"Approval 3 tingkat<br/>Supervisor → Manager → Finance"}
    B2 -- Reject --> B1
    B2 -- APPROVE3 --> P1["4. Progress Perbaikan<br/>% per CT, tidak boleh turun"]
    P1 --> P2{"Supervisor approve?"}
    P2 -- Reject --> P1
    P2 -- Approve --> C1["5. BAST dari Vendor / BAST 2<br/>POST → progress 100%"]
    C1 --> C2{"Supervisor approve?"}
    C2 -- Reject --> C1
    C2 -- Approve --> C3["Hitung garansi dari kontrak<br/>BAST 1 is_done = true<br/>CT → SO"]
    C3 --> A4["6. Aktivitas Harian<br/>Naik Container<br/>CT → O"]
    A4 --> S
```

> Catatan: secara kode, BAST 2 dan Progress bisa dibuat setelah BAST 1 berstatus **≠ DRAFT** (belum harus APPROVE3).

## 4. Status container

```mermaid
stateDiagram-v2
    direction LR
    O: O · Operasional
    SO: SO · Siap Operasi
    TSO: TSO · Tidak Siap Operasi
    SOI: SOI · Siap Operasi Isi
    TSOI: TSOI · Tidak Siap Operasi Isi
    S: S · Scrap

    [*] --> O
    O --> SO: Putus Gerbong / CT-DT / Turun di BJI-BBA
    O --> TSO: Turun Container / POST Inspeksi
    SO --> O: Naik Container / Container Uplift
    SOI --> O: Naik Container
    SO --> SOI: Truck Unloading
    SO --> TSOI: POST Inspeksi
    SOI --> TSOI: POST Inspeksi
    TSOI --> TSO: Container Unloading
    TSO --> SO: Approve BAST 2
    TSOI --> SO: Approve BAST 2
    TSO --> S: Approve Scrap
    S --> [*]
```

| Kode | Warna dashboard | Diubah di |
|---|---|---|
| O / SO / SOI / TSO / TSOI | `#FFFFFF` / `#FFFF00` / `#F5E342` / `#F4B083` (Maint.), `#C55A11` (Upgrade) / `#BCC9AB` | `R/ContainerDailyActivityRepository.php:26` (posted) |
| TSO / TSOI | | `R/InspectionRepository.php:61-67` |
| SO | | `R/ContainerDelegationFromVendorRepository.php:166-178` |
| S | `#FF0000` | `R/ContainerScrapRepository.php:129-131` |

Semua perubahan lewat `Container::updateStatusByCode()` (`M/Container.php:89`).

## 5. Pola status transaksi

```mermaid
flowchart LR
    DR["DRAFT<br/>bisa edit / hapus"] -->|POST| PO["POSTED<br/>menunggu approval"]
    PO -->|Approve 1 tingkat| AP["APPROVE<br/>Inspeksi · Progress · BAST 2"]
    PO -->|Approve tahap 1| A1["APPROVE1"]
    A1 -->|tahap 2| A2["APPROVE2"]
    A2 -->|tahap 3| A3["APPROVE3<br/>BAST 1 final"]
    PO -->|Reject| DR
    A1 -->|Reject| PO
    A2 -->|Reject| PO
```

`app/Enums/StatusEnum.php` · Aktivitas Harian berhenti di **POSTED** (tanpa approval).

## 6. BP-02 Aktivitas harian

```mermaid
flowchart TD
    A(["Checker"]) --> B["Buat header: lokasi, tanggal<br/>C/ContainerDailyActivityController.php:30"]
    B --> C{"Cara input detail?"}
    C -- Manual --> D["Pilih jenis aktivitas"]
    D --> E["Dropdown CT difilter per jenis<br/>L/ContainerDailyActivity/FormDetail.php:79"]
    E --> F{"Naik Container dan<br/>CT TSO masih di BAST 1<br/>is_done = 0?"}
    F -- Ya --> G["Ditolak: CT belum selesai di BAST 1"]
    F -- Tidak --> H["Simpan detail<br/>FormDetail.php:175"]
    C -- "Upload Excel" --> I["File xls/xlsx<br/>kolom ct_no, container_source,<br/>carriage_number, type"]
    I --> J["ContainerDailyActivityDetailsImport<br/>FormDetail.php:220"]
    J --> K{"Semua baris berhasil?"}
    K -- Tidak --> L["SEMUA detail transaksi dihapus<br/>FormDetail.php:263"]
    K -- Ya --> H
    H --> M{"POST?"}
    M -- Ya --> N["Per detail: ubah status CT sesuai jenis<br/>+ isi down_* / up_*<br/>R/ContainerDailyActivityRepository.php:26"]
    N --> O(["POSTED"])
    M -- "Tidak, > 7 hari" --> P["Draft dihapus otomatis saat<br/>daftar dibuka · markDraftAsDeleted"]
```

| Jenis aktivitas | CT yang boleh dipilih | Status setelah POST |
|---|---|---|
| Turun Container | TSO (BJI/BBA: O, TSO) | TSO, atau SO di lokasi id 2/3 |
| Naik Container | SO, TSO, SOI | SO/SOI → O, TSO tetap TSO |
| Putus Gerbong | O | SO |
| CT-DT | SO, O | SO |
| Truck Unloading | SO | SOI |
| Container Uplift | SO | O |
| Container Unloading | TSOI | TSO |

## 7. BP-03 Inspeksi

```mermaid
flowchart TD
    A(["Checker"]) --> B["Buat header: lokasi, tanggal, no. KA<br/>C/InspectionController.php:31"]
    B --> C["Tambah detail: CT, kerusakan,<br/>penyebab, foto<br/>L/Inspection/FormDetail.php:37"]
    C --> D{"Ada detail?"}
    D -- Tidak --> C
    D -- Ya --> E["POST<br/>R/InspectionRepository.php:41"]
    E --> F{"Status CT SO / SOI?"}
    F -- Ya --> G["CT → TSOI"]
    F -- Tidak --> H["CT → TSO"]
    G --> I["Email ke semua Supervisor"]
    H --> I
    I --> J{"Config whatsapp-notif aktif?"}
    J -- Ya --> K["Kirim laporan ke grup WA<br/>+ link foto"]
    J -- Tidak --> L(["POSTED"])
    K --> L
    L --> M["Supervisor isi jenis perbaikan<br/>+ root cause per detail<br/>L/Inspection/FormHeader.php · FormRootCause.php"]
    M --> N{"Keputusan Supervisor"}
    N -- Reject --> O["Kembali DRAFT<br/>email ke Checker pembuat<br/>status CT tidak dikembalikan"]
    O --> C
    N -- Approve --> P{"Jenis perbaikan &<br/>semua root cause terisi?"}
    P -- Tidak --> Q["Error"] --> M
    P -- Ya --> R["containers.last_type_maintenance diisi<br/>email ke Checker<br/>R/InspectionRepository.php:118"]
    R --> S(["APPROVE"])
```

## 8. BP-04 BAST ke Vendor (BAST 1)

```mermaid
flowchart TD
    A(["Checker"]) --> B["Header: vendor, kontrak, lokasi,<br/>jenis Maintenance / Upgrade & Repair<br/>L/ContainerDelegationToVendor/FormCreate.php"]
    B --> C["Pilih CT<br/>L/ContainerDelegationToVendor/FormDetail.php:31"]
    C --> D{"CT pernah diinspeksi, status TSO/TSOI,<br/>tidak di BAST 1 lain yang belum selesai?"}
    D -- Tidak --> X["Tidak muncul di dropdown"]
    D -- Ya --> E{"Sudah Turun Container?<br/>down_at ada dan up_at < down_at"}
    E -- Tidak --> Y["Ditolak: belum Turun Container"]
    E -- Ya --> F["Simpan detail + buat sub-detail<br/>otomatis dari detail inspeksi<br/>FormDetail.php:84"]
    F --> G["Isi item pekerjaan dari detail kontrak<br/>qty × harga = estimasi<br/>FormSubDetail.php · FormEditSubDetail.php"]
    G --> H["POST<br/>R/ContainerDelegationToVendorRepository.php:32"]
    H --> I["Isi last_maintenance_* / last_upgrade_*<br/>di CT, email Supervisor"]
    I --> J{"Supervisor"}
    J -- Reject --> B
    J -- Approve --> K{"Maintenance: semua CT punya<br/>sub-detail + root cause?"}
    K -- Tidak --> J
    K -- Ya --> L["APPROVE1 · email Manager"]
    L --> M{"Manager"}
    M -- Reject --> N["Kembali POSTED · email Supervisor"] --> J
    M -- Approve --> O["APPROVE2 · email Finance"]
    O --> P{"Finance"}
    P -- Reject --> Q["Kembali POSTED · email Spv + Mgr"] --> J
    P -- Approve --> R(["APPROVE3 · email Spv + Mgr"])
    R -.->|"Unapprove oleh Spv/Admin<br/>jika CT belum diproses di BAST 2"| B
```

> ⚠ Bug: kondisi `role == 'Administrator' || role == 'X' && status == …` membuat Administrator selalu masuk cabang **APPROVE1** (`ContainerDelegationToVendorRepository.php:158`). Reject menghapus tanggal & vendor maintenance/upgrade di CT.

## 9. BP-05 Progress perbaikan

```mermaid
flowchart TD
    A(["Checker"]) --> B["Pilih vendor + lokasi<br/>R/ContainerRepairRepository.php:31"]
    B --> C{"Ada BAST 1 ≠ DRAFT<br/>untuk vendor + lokasi?"}
    C -- Tidak --> D["Error: belum ada data BAST"]
    C -- Ya --> E["Buat baris progress untuk tiap CT<br/>is_done = 0, bawa progress terakhir"]
    E --> F["Update % per CT / massal<br/>L/ContainerRepair/ContainerRepairProgress.php"]
    F --> G{"0–100 dan ≥ progress sebelumnya?"}
    G -- Tidak --> F
    G -- Ya --> H["POST · email Supervisor<br/>R/ContainerRepairRepository.php:82"]
    H --> I{"Supervisor"}
    I -- Reject --> J["DRAFT · email Checker<br/>⚠ typo baris 126"] --> F
    I -- Approve --> K{"Masih ada progress lama<br/>vendor + lokasi sama DRAFT/POSTED?"}
    K -- Ya --> L["Ditolak"]
    K -- Tidak --> M(["APPROVE · email Checker"])
```

## 10. BP-06 BAST dari Vendor (BAST 2) & garansi

```mermaid
flowchart TD
    A(["Checker"]) --> B["Header: vendor, lokasi, jenis<br/>harus sama dengan BAST 1"]
    B --> C["Pilih CT<br/>L/ContainerDelegationFromVendor/FormDetail.php:91"]
    C --> D{"CT ada di BAST 1 ≠ DRAFT, is_done = 0,<br/>status TSO/TSOI, belum di BAST 2 lain?"}
    D -- Tidak --> X["Tidak muncul di dropdown"]
    D -- Ya --> E{"Punya progress perbaikan ≠ DRAFT?"}
    E -- Tidak --> Y["Error: belum ada progress POSTED"]
    E -- Ya --> F["Simpan detail, salin sub-detail BAST 1<br/>FormDetail.php:137"]
    F --> G["Upload foto sesudah perbaikan<br/>FormEditImageSubDetail.php"]
    G --> H["POST: progress semua detail = 100<br/>email Supervisor<br/>R/ContainerDelegationFromVendorRepository.php:50"]
    H --> I{"Supervisor"}
    I -- Reject --> J["DRAFT · is_done BAST 1 = false<br/>email Checker"] --> F
    I -- Approve --> K["calculateWarrantyFromDate<br/>R/ContractRepository.php:70"]
    K --> L{"Jenis pekerjaan?"}
    L -- "Upgrade & Repair" --> M["containers.upgrade_warranty_start/end"]
    L -- Maintenance --> N["warranty_start/end per sub-detail"]
    M --> O["Detail BAST 1 is_done = true"]
    N --> O
    O --> P{"Ada record CT lebih baru<br/>di view v_ct_record?"}
    P -- Ya --> Q(["APPROVE · status CT tidak diubah"])
    P -- Tidak --> R(["APPROVE · CT → SO"])
```

**Rumus garansi:** `akhir = tanggal BAST 2 + warranty_in_days` hari; jika kosong `+ warranty_in_month` bulan (dari kontrak BAST 1).

## 11. BP-07 Scrap

```mermaid
flowchart TD
    A(["Supervisor"]) --> B["Header: vendor, lokasi, jenis,<br/>alasan, dokumen<br/>C/ContainerScrapController.php:32"]
    B --> C["Pilih CT berstatus TSO<br/>L/ContainerScrap/FormDetail.php:39"]
    C --> D{"CT masih di BAST 1<br/>belum selesai?"}
    D -- Ya --> E["Ditolak"]
    D -- Tidak --> F{"Sudah ada di scrap<br/>DRAFT/POSTED lain?"}
    F -- Ya --> E
    F -- Tidak --> G["Simpan detail: foto + persentase"]
    G --> H["POST · email Manager<br/>R/ContainerScrapRepository.php:43"]
    H --> I{"Manager"}
    I -- Reject --> J["DRAFT · email Supervisor"] --> C
    I -- Approve --> K(["APPROVE1 · CT → S<br/>email Manager"])
    K -.->|"⚠ Finance tidak bisa akses route approve"| L["APPROVE2 · tidak tercapai"]
```

## 12. Notifikasi email & WhatsApp

```mermaid
sequenceDiagram
    autonumber
    actor CK as Checker
    participant APP as CTC Web
    actor SPV as Supervisor
    actor MGR as Manager
    actor FIN as Finance
    participant WA as Grup WA

    CK->>APP: POST Inspeksi
    APP-->>SPV: Email InspectionNotification
    APP-->>WA: Laporan kerusakan + foto (jika whatsapp-notif aktif)
    SPV->>APP: Approve / Reject Inspeksi
    APP-->>CK: Email Approved / Rejected

    CK->>APP: POST BAST 1
    APP-->>SPV: Email DelegationToVendor
    SPV->>APP: Approve → APPROVE1
    APP-->>MGR: Email Approve
    MGR->>APP: Approve → APPROVE2
    APP-->>FIN: Email Approve
    FIN->>APP: Approve → APPROVE3
    APP-->>SPV: Email Approve
    APP-->>MGR: Email Approve

    CK->>APP: POST Progress / BAST 2
    APP-->>SPV: Email notifikasi
    SPV->>APP: Approve / Reject
    APP-->>CK: Email hasil (BAST 2 hanya saat reject)

    SPV->>APP: POST Scrap
    APP-->>MGR: Email ContainerScrapNotif
    MGR->>APP: Approve / Reject
    APP-->>SPV: Email Reject (Approve → Manager)
```

> Semua Mailable `ShouldQueue`, tetapi `.env.example` memakai `QUEUE_CONNECTION=sync`, sehingga email dikirim langsung di dalam DB transaction. SMTP gagal = POST/approve gagal.

## 13. Dashboard & cek layanan WhatsApp

```mermaid
flowchart TD
    A(["User buka Dashboard"]) --> B["WhatspieService::getStatus<br/>GET 172.16.10.114:3000/session/status"]
    B --> C{"state = CONNECTED?"}
    C -- Ya --> F["Tampilkan dashboard"]
    C -- Tidak --> D{"Config whatsapp-notif aktif?"}
    D -- Tidak --> F
    D -- Ya --> E["Set whatsapp-notif = 0<br/>email ke it@baracoal.com<br/>banner NOT CONNECTED"]
    E --> F
    F --> G["Data dari view v_ct_so_tso<br/>+ chart v_ct_bast_rekap"]
    H(["Administrator menu Config"]) --> I["Start session → scan QR<br/>ConfigController.php:82"]
    I --> J["Aktifkan lagi whatsapp-notif"]
```

> Dashboard error 500 jika baris config `whatsapp-notif` tidak ada (`C/DashboardController.php:30`).

## 14. Deploy

```mermaid
flowchart LR
    A["git push"] --> B{"pre-push hook<br/>php artisan test lulus?"}
    B -- Tidak --> X["Push dibatalkan"]
    B -- Ya --> C["GitHub<br/>itbaracoal/baracoal-cms"]
    C --> D["dep deploy<br/>deploy.php"]
    D --> E["172.16.10.28<br/>/var/www/html · branch main"]
    E --> F["composer install"]
    F --> G["npm install && npm run prod"]
    G --> H["symlink release"]
    H --> I["clear opcache php8.1-fpm"]
    I --> J["artisan queue:restart"]
```

> Tidak ada scheduler: `app/Console/Kernel.php` → `schedule()` kosong.

## 15. Ringkasan file per proses

| Proses | Route (`routes/admin.php`) | Controller | Repository | Livewire |
|---|---|---|---|---|
| Login | `:36-37` | `C/Auth/LoginController.php` | – | – |
| Master data | `:50-165`, `:195-229` | `C/Master/*Controller.php` | `R/*Repository.php` | `L/Container/WarrantyModal.php` |
| Aktivitas harian | `:231-250` | `C/ContainerDailyActivityController.php` | `R/ContainerDailyActivityRepository.php` | `L/ContainerDailyActivity/*` |
| Inspeksi | `:170-192` | `C/InspectionController.php` | `R/InspectionRepository.php` | `L/Inspection/*` |
| BAST 1 | `:253-288` | `C/DelegationToVendorController.php` | `R/ContainerDelegationToVendorRepository.php` | `L/ContainerDelegationToVendor/*` |
| Progress | `:291-312` | `C/ContainerRepairController.php` | `R/ContainerRepairRepository.php` | `L/ContainerRepair/ContainerRepairProgress.php` |
| BAST 2 | `:345-379` | `C/DelegationFromVendorController.php` | `R/ContainerDelegationFromVendorRepository.php` | `L/ContainerDelegationFromVendor/*` |
| Scrap | `:315-342` | `C/ContainerScrapController.php` | `R/ContainerScrapRepository.php` | `L/ContainerScrap/*` |
| Report | `:383-396` | `C/Report/*Controller.php` | `R/CTCReportRepository.php`, `R/BastReportRepository.php` | `L/Report/*`, `L/ContainerDashboard/*` |
| Dashboard & WA | `:40` | `C/DashboardController.php`, `C/Master/ConfigController.php` | `app/Services/WhatspieService.php` | `L/Dashboard/*`, `L/WAService/*` |

Nomor baris mengacu pada source saat dokumen ini disusun dan bisa bergeser jika kode diubah.
