$(function () {
    const $navToggle = $(".nav-toggle");
    const $navPanel = $("#site-nav");
    const $videoSearch = $("[data-video-search]");
    const $videoYear = $("[data-video-year]");
    const $videoSummary = $("[data-video-summary]");
    const $videoEmpty = $("[data-video-empty]");

    $("#upload-dialog").dialog({
        autoOpen: false,
        modal: true,
        width: Math.min(window.innerWidth - 24, 560)
    });

    $("#open-upload").on("click", function () {
        $("#upload-dialog").dialog("open");
    });

    $navToggle.on("click", function () {
        const isOpen = $navPanel.hasClass("is-open");
        $navPanel.toggleClass("is-open", !isOpen);
        $(this).attr("aria-expanded", String(!isOpen));
    });

    $(window).on("resize", function () {
        if (window.innerWidth >= 980) {
            $navPanel.removeClass("is-open");
            $navToggle.attr("aria-expanded", "false");
        }
    });

    function normalizeText(value) {
        return String(value || "").toLowerCase().trim();
    }

    function applyVideoFilters() {
        const activeFilter = $('[data-filter-group="video-status"] .chip-active').data("filter") || "all";
        const searchValue = String($videoSearch.val() || "");
        const searchText = normalizeText(searchValue);
        const selectedYear = String($videoYear.val() || "all");
        let visibleCount = 0;

        $("[data-video-card]").each(function () {
            const $card = $(this);
            const status = String($card.data("status") || "");
            const year = String($card.data("year") || "");
            const searchIndex = normalizeText($card.data("search"));
            const statusMatch = activeFilter === "all" || status === activeFilter;
            const yearMatch = selectedYear === "all" || year === selectedYear;
            const searchMatch = searchText === "" || searchIndex.includes(searchText);
            const show = statusMatch && yearMatch && searchMatch;

            $card.toggle(show);

            if (show) {
                visibleCount += 1;
            }
        });

        if ($videoSummary.length) {
            const yearLabel = selectedYear === "all" ? "alla år" : selectedYear;
            const statusLabel = activeFilter === "all" ? "alla statusar" : activeFilter.toLowerCase();
            const searchLabel = searchText === "" ? "" : ` med sökning på "${searchValue}"`;
            $videoSummary.text(`Visar ${visibleCount} videos för ${yearLabel}, ${statusLabel}${searchLabel}.`);
        }

        if ($videoEmpty.length) {
            $videoEmpty.prop("hidden", visibleCount !== 0);
        }
    }

    function applyExerciseSearch(scope) {
        const $input = $(`[data-exercise-search="${scope}"]`);
        const searchText = normalizeText($input.val());
        let visibleRows = 0;

        $(`[data-exercise-group="${scope}"]`).each(function () {
            const $group = $(this);
            let groupHasVisibleRows = false;

            $group.find(`[data-exercise-row="${scope}"]`).each(function () {
                const $row = $(this);
                const searchIndex = normalizeText($row.data("search"));
                const show = searchText === "" || searchIndex.includes(searchText);

                $row.toggle(show);

                if (show) {
                    groupHasVisibleRows = true;
                    visibleRows += 1;
                }
            });

            $group.toggle(groupHasVisibleRows);
        });

        const $summary = $(`[data-exercise-summary="${scope}"]`);
        if ($summary.length) {
            const baseText = scope === "grunder"
                ? "Visar alla grundövningar."
                : "Visar alla fortsättningsmoment.";
            const resultText = scope === "grunder"
                ? `Visar ${visibleRows} grundövningar som matchar sökningen.`
                : `Visar ${visibleRows} forts-moment som matchar sökningen.`;

            $summary.text(searchText === "" ? baseText : resultText);
        }

        const $empty = $(`[data-exercise-empty="${scope}"]`);
        if ($empty.length) {
            $empty.prop("hidden", visibleRows !== 0);
        }
    }

    $('[data-filter-group="video-status"] .chip').on("click", function () {
        const $group = $(this).closest("[data-filter-group]");
        $group.find(".chip").removeClass("chip-active");
        $(this).addClass("chip-active");
        applyVideoFilters();
    });

    $videoSearch.on("input", applyVideoFilters);
    $videoYear.on("change", applyVideoFilters);

    $("[data-exercise-search]").on("input", function () {
        applyExerciseSearch($(this).data("exercise-search"));
    });

    if ($("[data-video-card]").length) {
        applyVideoFilters();
    }

    if ($("[data-exercise-search=\"grunder\"]").length) {
        applyExerciseSearch("grunder");
    }

    if ($("[data-exercise-search=\"forts\"]").length) {
        applyExerciseSearch("forts");
    }
});
