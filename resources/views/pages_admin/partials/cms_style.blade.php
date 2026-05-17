<style>
/* --- 1. RESET BACKGROUND AGAR 100% DARK THEME --- */
body, .admin-container, .main-content, .content-body, section.content-body, .wrap, .page-wrapper { 
    background: #0a0a0a !important; 
    background-color: #0a0a0a !important; 
}

/* --- 2. STYLING CMS KONTEN --- */
.cms-header { margin-bottom: 20px; } 
.cms-header h2 { font-size: 20px; color: #fff; margin: 0 0 5px 0; font-weight: 700; } 
.cms-header p { color: #888; font-size: 13px; margin: 0; }

.cms-card { background: #111; border: 1px solid #1e1e1e; border-radius: 8px; padding: 25px; margin-bottom: 40px; box-shadow: none; }

.form-group { margin-bottom: 20px; } 
.form-group label { display: block; color: #888; font-size: 11px; font-weight: 700; text-transform: uppercase; margin-bottom: 8px; }

.form-control { width: 100%; background: #0a0a0a; border: 1px solid #333; color: #fff; padding: 12px 15px; border-radius: 6px; font-family: inherit; font-size: 14px; transition: 0.3s; }
.form-control:focus { border-color: #D4A373; outline: none; box-shadow: 0 0 0 2px rgba(212,163,115,0.1); } 
textarea.form-control { resize: vertical; }

.img-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; } 
.img-box { background: #0a0a0a; border: 1px solid #222; border-radius: 6px; padding: 10px; height: 180px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; } 
.img-box img { max-width: 100%; max-height: 100%; object-fit: contain; }

.upload-box { border: 1px dashed #444; cursor: pointer; transition: 0.3s; } 
.upload-box:hover { border-color: #D4A373; background: rgba(212, 163, 115, 0.05); } 
.upload-box i { font-size: 28px; color: #666; margin-bottom: 10px; transition: 0.3s; } 
.upload-box:hover i { color: #D4A373; transform: translateY(-3px); }
.upload-box p { margin: 0; font-size: 13px; color: #aaa; } 
input[type="file"] { display: none; }

.btn-row { margin-top: 30px; } 
.btn-simpan { background: #D4A373; color: #111; border: none; padding: 10px 22px; border-radius: 6px; font-weight: 800; cursor: pointer; transition: 0.2s; }
.btn-simpan:hover { background: #b58555; }

.alert-success { background: rgba(16,185,129,.1); color: #10b981; padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid rgba(16,185,129,.2); }
</style>