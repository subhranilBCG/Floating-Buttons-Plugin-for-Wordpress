/* jshint esversion:6 */
(function () {
    "use strict";

    // ── Color Picker Sync ────────────────────────────────────────────────────

    function isValidHex(v) { return /^#[0-9A-Fa-f]{6}$/.test(v); }

    document.querySelectorAll(".fcb-cp-wrap").forEach(function (wrap) {
        var native = wrap.querySelector(".fcb-color-native");
        var hex    = wrap.querySelector(".fcb-cp-hex");
        var swatch = wrap.querySelector(".fcb-cp-swatch");
        if (!native || !hex || !swatch) return;

        native.addEventListener("input", function () {
            hex.value = native.value;
            swatch.style.background = native.value;
            updatePreview();
        });

        hex.addEventListener("input", function () {
            var v = hex.value.trim();
            if (!v.startsWith("#")) v = "#" + v;
            if (isValidHex(v)) {
                native.value = v;
                swatch.style.background = v;
                updatePreview();
            }
        });
    });

    // ── Button Type Toggle ───────────────────────────────────────────────────

    function toggleTypeFields(idx, type) {
        var showPhone = (type === "whatsapp" || type === "tel");
        var showEmail = (type === "email");
        var showUrl   = (type === "custom");

        var phone = document.querySelector(".fcb-phone-field-" + idx);
        var email = document.querySelector(".fcb-email-field-" + idx);
        var url   = document.querySelector(".fcb-url-field-" + idx);

        if (phone) phone.style.display = showPhone ? "" : "none";
        if (email) email.style.display = showEmail ? "" : "none";
        if (url)   url.style.display   = showUrl   ? "" : "none";
    }

    document.querySelectorAll(".fcb-btn-type").forEach(function (sel) {
        sel.addEventListener("change", function () {
            toggleTypeFields(sel.dataset.index, sel.value);
            updatePreview();
        });
    });

    // ── Icon Picker ──────────────────────────────────────────────────────────

    document.querySelectorAll(".fcb-icon-picker").forEach(function (picker) {
        var hidden = picker.querySelector(".fcb-icon-val");
        picker.querySelectorAll(".fcb-icon-opt").forEach(function (opt) {
            opt.addEventListener("click", function () {
                picker.querySelectorAll(".fcb-icon-opt").forEach(function(o){ o.classList.remove("fcb-icon-sel"); });
                opt.classList.add("fcb-icon-sel");
                if (hidden) hidden.value = opt.dataset.val;
                updatePreview();
            });
        });
    });

    // ── Preview ──────────────────────────────────────────────────────────────

    var previewContainer = document.getElementById("fcb-preview-buttons");

    function getVal(name) {
        var el = document.querySelector('[name="' + name + '"]');
        return el ? el.value : "";
    }
    function getChecked(name) {
        var el = document.querySelector('[name="' + name + '"]');
        return el && el.checked;
    }

    function updatePreview() {
        if (!previewContainer) return;
        previewContainer.innerHTML = "";

        var position = getVal("fcb[position]") || "bottom-right";
        var orient   = getVal("fcb[orientation]") || "vertical";
        var ox = parseInt(getVal("fcb[offset_x]"), 10) || 16;
        var oy = parseInt(getVal("fcb[offset_y]"), 10) || 16;
        var px = Math.round(ox * 0.85); // Increased from 0.45 
        var py = Math.round(oy * 0.85); 

        previewContainer.style.top    = "";
        previewContainer.style.bottom = "";
        previewContainer.style.left   = "";
        previewContainer.style.right  = "";

        var isBottom = position.includes("bottom");
        var isRight  = position.includes("right");

        previewContainer.style[isBottom ? "bottom" : "top"]  = py + "px";
        previewContainer.style[isRight  ? "right"  : "left"] = px + "px";

        // Layout direction mapping matching CSS
        if (orient === "horizontal") {
            previewContainer.style.flexDirection = isRight ? "row-reverse" : "row";
            previewContainer.style.alignItems    = isBottom ? "flex-end" : "flex-start";
        } else {
            previewContainer.style.flexDirection = isBottom ? "column-reverse" : "column";
            previewContainer.style.alignItems    = isRight ? "flex-end" : "flex-start";
        }

        for (var i = 0; i < 3; i++) {
            if (!getChecked("fcb[buttons][" + i + "][enabled]")) continue;

            var label    = getVal("fcb[buttons][" + i + "][label]")    || "Button";
            var bg       = getVal("fcb[buttons][" + i + "][bg]")       || "#000";
            var text     = getVal("fcb[buttons][" + i + "][text]")     || "#fff";
            var shape    = getVal("fcb[buttons][" + i + "][shape]")    || "pill";
            var size     = parseInt(getVal("fcb[buttons][" + i + "][size]"),     10) || 40;
            var iconSz   = parseInt(getVal("fcb[buttons][" + i + "][icon_size]"), 10) || 20;
            var padX     = parseInt(getVal("fcb[buttons][" + i + "][padding_x]"), 10) || 20;
            var iconEl   = document.querySelector('.fcb-icon-picker .fcb-icon-val[name="fcb[buttons][' + i + '][icon]"]');
            var icon     = iconEl ? iconEl.value : "";

            // Increased multipliers since the canvas is much larger than the phone mockup
            var ph      = Math.round(size * 0.9);
            var pIconSz = Math.round(iconSz * 0.9);
            var pPadX   = Math.round(padX  * 0.9);

            var btn = document.createElement("div");
            btn.className = "fcb-preview-btn";
            btn.style.cssText = "background:" + bg + ";color:" + text + ";height:" + ph + "px;display:inline-flex;align-items:center;justify-content:center;gap:4px;padding:0 " + pPadX + "px;font-size:12px;font-weight:600;font-family:sans-serif;white-space:nowrap;box-shadow:0 2px 8px rgba(0,0,0,0.2);";

            switch (shape) {
                case "circle": btn.style.borderRadius = "50%"; btn.style.width = ph + "px"; btn.style.padding = "0"; break;
                case "pill":   btn.style.borderRadius = "999px"; break;
                default:       btn.style.borderRadius = "5px"; break;
            }

            // Icon display in preview
            if (icon === "fcb-whatsapp") {
                btn.innerHTML = '<svg viewBox="0 0 24 24" fill="currentColor" width="10" height="10" style="flex-shrink:0"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>'
                    + (shape !== "circle" ? '<span style="margin-left:4px">' + label + '</span>' : '');
            } else if (icon && icon.indexOf("dashicons-") === 0) {
                var sp = document.createElement("span");
                sp.className = "dashicons " + icon;
                sp.style.cssText = "font-size:12px;width:12px;height:12px;flex-shrink:0";
                btn.appendChild(sp);
                if (shape !== "circle") {
                    var lb = document.createElement("span");
                    lb.textContent = label;
                    lb.style.marginLeft = "4px";
                    btn.appendChild(lb);
                }
            } else {
                btn.textContent = (shape === "circle") ? label.charAt(0) : label;
            }

            previewContainer.appendChild(btn);
        }
    }

    document.querySelectorAll("input, select").forEach(function (el) {
        el.addEventListener("input",  updatePreview);
        el.addEventListener("change", updatePreview);
    });

    updatePreview();
})();