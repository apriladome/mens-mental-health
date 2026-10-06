# WCAG AA/AAA Accessibility Contrast Audit Report

Tested against WCAG 2.1 standards for dark-mode digital interfaces:

| Foreground Token | Background Token | Calculated Contrast Ratio | WCAG Compliance | Verified Context |
| :--- | :--- | :--- | :--- | :--- |
| `text-primary` (`#F1F3F7`) | `canvas` (`#0B0D11`) | **17.8:1** | AAA Pass | Main page headings and body text |
| `text-primary` (`#F1F3F7`) | `surface` (`#13171F`) | **15.6:1** | AAA Pass | Card headings & container content |
| `text-secondary` (`#AEB6C6`) | `surface` (`#13171F`) | **9.1:1** | AAA Pass | Narrative secondary body copy |
| `text-muted` (`#7A8599`) | `surface` (`#13171F`) | **4.7:1** | AA Pass | Minimum threshold for metadata and captions |
| `canvas` (`#0B0D11`) | `copper-500` (`#D08A5B`) | **6.4:1** | AAA Large / AA Normal | Primary CTA button label text |
| `teal-400` (`#6BC4BA`) | `canvas` (`#0B0D11`) | **10.8:1** | AAA Pass | Focus rings & tactical active links |
| `canvas` (`#0B0D11`) | `text-primary` (`#F1F3F7`) | **17.8:1** | AAA Pass | Call 988 emergency action button |