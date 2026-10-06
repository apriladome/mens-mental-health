# Resilience Project — Design System Specification

## 1. Design Intent
"A well-built, quiet workshop at first light." Solid, warm, uncluttered, and competent.

## 2. Core Tokens
- **Canvas:** `#0B0D11`
- **Surface:** `#13171F` (Cards)
- **Surface Raised:** `#1A2030` (Modals, Hover states)
- **Border:** `#232938` (Default hairline)
- **Border Strong:** `#323B50` (Inputs)
- **Text Primary:** `#F1F3F7` (Never pure white)
- **Text Secondary:** `#AEB6C6`
- **Text Muted:** `#7A8599`
- **Copper-500:** `#D08A5B` (Primary CTA, warmth)
- **Teal-500:** `#4FB3A9` (Regulation, tool active states)
- **Moss:** `#6BBF8E` (Success)
- **Brass:** `#E0B04A` (Warning)
- **Brick:** `#E26D5F` (Danger, safety intercepts)

## 3. Typography
- **Headings:** Source Serif 4 (500, 600)
- **Body & UI:** Inter (400, 500, 600)
- **Numbers & Readouts:** JetBrains Mono (tabular numerals)

## 4. Components
Available in `resources/views/components/ui/`:
- `<x-ui.button variant="primary|secondary|ghost|danger" size="sm|md|lg" />`
- `<x-ui.card variant="default|raised|interactive" />`
- `<x-ui.section-header overline="..." title="..." description="..." />`
- `<x-ui.avatar name="..." size="sm|md|lg" />`
- `<x-ui.input label="..." name="..." />`
- `<x-ui.textarea label="..." name="..." />`
- `<x-ui.select label="..." name="..." />`
- `<x-ui.slider label="..." min="1" max="10" />`
- `<x-ui.toggle label="..." />`
- `<x-ui.checkbox label="..." />`
- `<x-ui.badge variant="teal|copper|moss|brass|brick" />`
- `<x-ui.tag />`
- `<x-ui.tabs :tabs="['tab1' => 'Tab 1', 'tab2' => 'Tab 2']" />`
- `<x-ui.accordion title="..." />`
- `<x-ui.modal name="..." title="..." />`
- `<x-ui.slide-over name="..." title="..." />`
- `<x-ui.toast message="..." />`
- `<x-ui.progress-bar :value="65" />`
- `<x-ui.progress-ring :percentage="75" />`
- `<x-ui.stat-tile label="..." value="..." />`
- `<x-ui.empty-state icon="..." title="..." />`
- `<x-ui.skeleton class="h-6 w-32" />`
- `<x-icon name="..." size="16|20|24|32" />`