import React from 'react';

interface Props {
  ufs: string[];
  selectedUf: string;
  onChange: (e: React.ChangeEvent<HTMLSelectElement>) => void;
}

const UfSelect = ({ ufs, selectedUf, onChange }: Props) => (
  <div>
    <label htmlFor="uf" className="form-label">Selecione o estado (UF):</label>
    <select
      id="uf"
      className="form-select"
      value={selectedUf}
      onChange={onChange}
    >
      {ufs.map(uf => (
        <option key={uf} value={uf}>{uf}</option>
      ))}
    </select>
  </div>
);

export default UfSelect;