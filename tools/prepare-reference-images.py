"""Optimize original Higgsfield assets and create labeled review sheets (no visual retouching)."""
import json
import hashlib
from pathlib import Path
from PIL import Image, ImageDraw, ImageOps

root = Path(__file__).resolve().parent.parent
source = root / '.image-source/sunburst'
target = root / 'assets/images/reference'
target.mkdir(parents=True, exist_ok=True)
manifest = root / 'tools/sunburst-jobs.json'
if not manifest.exists():
    manifest = root / 'docs/media/reference-images.json'
jobs = json.loads(manifest.read_text(encoding='utf-8'))
available = sorted([j for j in jobs if (source / (j['slug'] + '.png')).is_file()], key=lambda j: j['index'])
if len(available) != 51:
    raise SystemExit(f'Expected 51 downloaded originals; found {len(available)}. Restore originals by recorded Higgsfield job ID before rebuilding.')
for job in available:
    image = Image.open(source / (job['slug'] + '.png')).convert('RGB')
    for width in (480, 960, 1200):
        resized = ImageOps.fit(image, (width, width * 3 // 4), Image.Resampling.LANCZOS)
        resized.save(target / f"{job['slug']}-{width}.webp", quality=83, method=6)
for offset in range(0, len(available), 18):
    group = available[offset:offset+18]
    sheet = Image.new('RGB', (1200, ((len(group)+2)//3)*250), '#f7f3eb')
    draw = ImageDraw.Draw(sheet)
    for index, job in enumerate(group):
        image = Image.open(source / (job['slug'] + '.png')).convert('RGB')
        image.thumbnail((390, 215))
        x, y = (index % 3)*400, (index//3)*250
        sheet.paste(image, (x, y))
        draw.text((x+6,y+222), f"{job['index']}: {job['slug']}", fill='#222222')
    sheet.save(source / f'review-{offset//18+1}.jpg', quality=90)
print(f'Prepared {len(available)} distinct assets, 3 responsive sizes each.')
provenance = [{key: job[key] for key in ('index', 'slug', 'name', 'job_id', 'model', 'prompt')} | {
    'variant': 'sunburst', 'quality': 'medium', 'resolution': '1k',
    'sha256_960': hashlib.sha256((target / (job['slug'] + '-960.webp')).read_bytes()).hexdigest(),
    'reference_only': True,
} for job in available]
(root / 'docs/media').mkdir(parents=True, exist_ok=True)
(root / 'docs/media/reference-images.json').write_text(json.dumps(provenance, ensure_ascii=False, indent=2) + '\n', encoding='utf-8')
