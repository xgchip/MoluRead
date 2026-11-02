/* MoluRead: refresh this quote only; keep the current document and scroll position. */
(function () {
  'use strict';
  document.querySelectorAll('.yiyan-widget[data-quotes-url]').forEach(function (widget) {
    if (widget.dataset.quoteReady) return;
    widget.dataset.quoteReady = 'true';
    var button = widget.querySelector('.yiyan-refresh-btn');
    var quote = widget.querySelector('.yiyan-quote');
    var author = widget.querySelector('.yiyan-author');
    var label = button.querySelector('span');
    var quotes;
    button.addEventListener('click', async function () {
      if (button.disabled) return;
      button.disabled = true;
      button.setAttribute('aria-busy', 'true');
      label.textContent = '正在换句';
      try {
        if (!quotes) {
          var controller = new AbortController();
          var timeout = setTimeout(function () { controller.abort(); }, 8000);
          try {
            var response = await fetch(widget.dataset.quotesUrl, { signal: controller.signal });
            if (!response.ok) throw new Error('Quote request failed');
            var text = await response.text();
            quotes = text.split(/\r?\n/).map(function (line) {
              var parts = line.trim().split('——');
              return { text: parts.shift().trim(), author: parts.join('——').trim() || '佚名' };
            }).filter(function (row) { return row.text; });
          } finally { clearTimeout(timeout); }
        }
        var choices = quotes.filter(function (row) { return row.text !== quote.textContent.trim(); });
        if (!choices.length) throw new Error('No alternative quote');
        var next = choices[Math.floor(Math.random() * choices.length)];
        quote.textContent = next.text;
        quote.title = next.text;
        author.textContent = '—— ' + next.author;
        author.title = next.author;
        label.textContent = '换一句';
        button.title = '换一句';
      } catch (error) {
        label.textContent = '重试';
        button.title = '暂时无法换句，请重试';
      } finally {
        button.disabled = false;
        button.removeAttribute('aria-busy');
      }
    });
  });
})();
