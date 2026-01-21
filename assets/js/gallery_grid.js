function masonryLayout() {
  const container = document.querySelector('.post-grid');
  const items = Array.from(container.children);
  const containerWidth = container.clientWidth;
  
  let columns = 6;
  if (window.innerWidth <= 1200) columns = 5;
  if (window.innerWidth <= 768) columns = 3;
  if (window.innerWidth <= 480) columns = 2;

  const columnHeights = new Array(columns).fill(0);
  const columnWidth = containerWidth / columns;

  items.forEach(item => {
    item.style.width = columnWidth + 'px';

    const minColumn = columnHeights.indexOf(Math.min(...columnHeights));

    const x = minColumn * columnWidth;
    const y = columnHeights[minColumn];

    item.style.transform = `translate(${x}px, ${y}px)`;

    columnHeights[minColumn] += item.offsetHeight;
  });

  container.style.height = Math.max(...columnHeights) + 'px';
}

window.addEventListener('load', masonryLayout);
window.addEventListener('resize', () => {
  clearTimeout(window._masonryTimer);
  window._masonryTimer = setTimeout(masonryLayout, 200);
});