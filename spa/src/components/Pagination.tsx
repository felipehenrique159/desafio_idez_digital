import React from 'react';

interface Props {
  page: number;
  lastPage: number;
  setPage: (page: number) => void;
}

function getPagination(current: number, last: number) {
  const delta = 2;
  const range = [];
  const rangeWithDots: (number | string)[] = [];
  let l: number | undefined;

  for (let i = 1; i <= last; i++) {
    if (i === 1 || i === last || (i >= current - delta && i <= current + delta)) {
      range.push(i);
    }
  }

  for (let i of range) {
    if (l !== undefined) {
      if (i - l === 2) {
        rangeWithDots.push(l + 1);
      } else if (i - l > 2) {
        rangeWithDots.push('...');
      }
    }
    rangeWithDots.push(i);
    l = i;
  }
  return rangeWithDots;
}

const Pagination = ({ page, lastPage, setPage }: Props) => (
  <nav>
    <div style={{ overflowX: 'auto' }}>
      <ul className="pagination flex-nowrap">
        <li className={`page-item${page === 1 ? ' disabled' : ''}`}>
          <button className="page-link" onClick={() => setPage(page - 1)} disabled={page === 1}>
            Anterior
          </button>
        </li>
        {getPagination(page, lastPage).map((p, i) =>
          typeof p === 'number' ? (
            <li key={p} className={`page-item${page === p ? ' active' : ''}`}>
              <button className="page-link" onClick={() => setPage(p)}>{p}</button>
            </li>
          ) : (
            <li key={`dots-${i}`} className="page-item disabled">
              <span className="page-link">...</span>
            </li>
          )
        )}
        <li className={`page-item${page === lastPage ? ' disabled' : ''}`}>
          <button className="page-link" onClick={() => setPage(page + 1)} disabled={page === lastPage}>
            Próxima
          </button>
        </li>
      </ul>
    </div>
  </nav>
);

export default Pagination;