import React from 'react';

interface City {
  name: string;
  ibge_code: string;
}

interface Props {
  cities: City[];
}

const CityTable = ({ cities }: Props) => (
  <table className="table table-striped">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Código Ibge</th>
      </tr>
    </thead>
    <tbody>
      {cities.length === 0 ? (
        <tr>
          <td colSpan={2}>Nenhuma cidade encontrada.</td>
        </tr>
      ) : (
        cities.map((city, idx) => (
          <tr key={idx}>
            <td>{city.name}</td>
            <td>{city.ibge_code}</td>
          </tr>
        ))
      )}
    </tbody>
  </table>
);

export default CityTable;