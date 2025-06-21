import React, { useEffect, useState } from 'react';
import axios from 'axios';
import './App.css';
import CityTable from './components/CityTable';
import Pagination from './components/Pagination';
import UfSelect from './components/UfSelect';
import SearchForm from './components/SearchForm';

interface City {
  name: string;
  ibge_code: string;
  [key: string]: any;
}

const ufs = [
  'AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'
];

interface ApiResponse {
  data: City[];
  current_page: number;
  last_page: number;
  total: number;
}

function App() {
  const [cities, setCities] = useState<City[]>([]);
  const [loading, setLoading] = useState(false);
  const [selectedUf, setSelectedUf] = useState('MG');
  const [search, setSearch] = useState('');
  const [searchInput, setSearchInput] = useState('');
  const [page, setPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [perPage, setPerPage] = useState(10);

  useEffect(() => {
    setLoading(true);
    axios
      .get<ApiResponse>(`http://localhost:80/api/cities/${selectedUf.toLowerCase()}`, {
        params: { search, page, per_page: perPage }
      })
      .then(res => {
        if (Array.isArray(res.data.data)) {
          setCities(res.data.data);
          setLastPage(res.data.last_page || 1);
        } else {
          setCities([]);
          setLastPage(1);
        }
      })
      .catch(() => {
        setCities([]);
        setLastPage(1);
      })
      .finally(() => setLoading(false));
  }, [selectedUf, search, page, perPage]);

  const handleSearch = (e: React.FormEvent) => {
    e.preventDefault();
    setPage(1);
    setSearch(searchInput);
  };

  const handleUfChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
    setSelectedUf(e.target.value);
    setPage(1);
    setSearch('');
    setSearchInput('');
  };

  return (
  <div className="container mt-5">
    <h1 className="mb-4">Cidades por Estado</h1>
    <div className="row mb-3">
      <div className="col-md-4">
        <UfSelect ufs={ufs} selectedUf={selectedUf} onChange={handleUfChange} />
      </div>
      <div className="col-md-8">
        <SearchForm searchInput={searchInput} setSearchInput={setSearchInput} onSearch={handleSearch} />
      </div>
    </div>
    {loading ? (
      <div className="alert alert-info">Carregando...</div>
    ) : (
      <>
        <div className="mb-3">
          <label htmlFor="perPage" className="form-label me-2">Itens por página:</label>
          <select
            id="perPage"
            className="form-select d-inline-block w-auto"
            value={perPage}
            onChange={e => { setPerPage(Number(e.target.value)); setPage(1); }}
            style={{ width: 120, display: 'inline-block' }}
          >
            {[5, 10, 20, 50, 100].map(n => (
              <option key={n} value={n}>{n}</option>
            ))}
          </select>
        </div>
        <CityTable cities={cities} />
        <Pagination page={page} lastPage={lastPage} setPage={setPage} />
      </>
    )}
  </div>
);
}

export default App;