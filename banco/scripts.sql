# Limpar banco e deixar apenas a estrutura. Isso é util para guardar uma cópia do banco antes de lançar uma versão

TRUNCATE `acertos`;
TRUNCATE `acertos_taxas`;
TRUNCATE `cooperativas`;
TRUNCATE `entradas`;
TRUNCATE `entradas_produtos`;
TRUNCATE `estoque`;
TRUNCATE `fechamentos`;
TRUNCATE `fechamentos_taxas`;
TRUNCATE `fornecedores_tiponegociacao`;
TRUNCATE `mestre_produtos_tipo`;
TRUNCATE `produtos`;
TRUNCATE `produtos_categorias`;
TRUNCATE `quantidade_ideal`;
TRUNCATE `quiosques`;
TRUNCATE `quiosques_caixas`;
TRUNCATE `quiosques_supervisores`;
TRUNCATE `quiosques_taxas`;
TRUNCATE `saidas`;
TRUNCATE `saidas_produtos`;
TRUNCATE `taxas`;
TRUNCATE `mestre_pessoas_tipo`;
DELETE FROM `pessoas` WHERE pes_codigo not in (1);
TRUNCATE `quiosques_tiponegociacao`;
