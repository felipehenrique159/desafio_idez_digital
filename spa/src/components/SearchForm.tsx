import React from 'react';

interface Props {
  searchInput: string;
  setSearchInput: (value: string) => void;
  onSearch: (e: React.FormEvent) => void;
}

const SearchForm = ({ searchInput, setSearchInput, onSearch }: Props) => (
  <form className="d-flex align-items-end" onSubmit={onSearch}>
    <div className="flex-grow-1 me-2">
      <label htmlFor="search" className="form-label">Buscar cidade:</label>
      <input
        id="search"
        type="text"
        className="form-control"
        value={searchInput}
        onChange={e => setSearchInput(e.target.value)}
        placeholder="Digite o nome da cidade"
      />
    </div>
    <button type="submit" className="btn btn-primary mb-1">Buscar</button>
  </form>
);

export default SearchForm;