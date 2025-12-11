# SICLOFI - Sistema de Controle Logístico de Fórmula Infantil

Sistema web para gerenciamento e controle de estoque de fórmula infantil destinada a bebês expostos ao HIV, desenvolvido para Unidades de Dispensação de Medicamentos (UDMs).

## Funcionalidades Principais

### Gestão de Cadastros
- Cadastro e consulta de bebês expostos ao HIV
- Registro de óbitos
- Gerenciamento de responsáveis e dados pessoais
- Atribuição automática de fórmula infantil por faixa etária

### Controle de Estoque
- Registro de entradas (recebimento, remanejamento, maternidade)
- Registro de saídas (remanejamento, maternidade, devolução, perda)
- Controle de lotes e validades
- Consulta de disponibilidade por UDM
- Sistema de alertas para estoque baixo e produtos próximos ao vencimento

### Relatórios e Ressuprimento
- Geração de relatórios em múltiplos formatos (PDF, XLSX, CSV)
- Solicitação de ressuprimento mensal
- Histórico de dispensações
- Auditoria de operações

## Tecnologias Utilizadas

- **Backend:** PHP 7.4+, MySQL 8.0+
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Bibliotecas:** Font Awesome 7.0.1
- **Arquitetura:** PDO para conexão segura com banco de dados

## Requisitos do Sistema

- PHP 7.4 ou superior
- MySQL 8.0 ou superior
- Servidor web (Apache/Nginx)
- Extensões PHP: PDO, PDO_MySQL, mbstring

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/siclofi.git
cd siclofi
```

2. Configure o banco de dados:
```bash
mysql -u root -p < database/siclofi.sql
```

3. Configure as credenciais em `config/conecta.php`:
```php
$host = "localhost";
$dbname = "siclofi";
$user = "seu_usuario";
$password = "sua_senha";
```

4. Acesse o sistema pelo navegador em `http://localhost/siclofi`

## Credenciais Padrão

### Farmacêuticos de Teste
- CPF: 98765432100 (UDM Central)
- CPF: 11122233344 (UDM Norte)
- Senha: 123456

## Estrutura do Projeto

```
siclofi/
├── ajax/              # Endpoints para requisições assíncronas
├── config/            # Configurações e conexão com banco
├── css/               # Folhas de estilo
├── database/          # Scripts SQL
├── functions/         # Funções auxiliares e autenticação
├── images/            # Recursos visuais
├── js/                # Scripts JavaScript
└── pages/             # Páginas da aplicação
  └── subpages/        # Subpáginas da aplicação
```

## Segurança

- Autenticação baseada em sessão
- Prepared statements para prevenção de SQL Injection
- Hash de senhas com bcrypt
- Controle de acesso por UDM
- Log de auditoria para todas operações críticas
- Proteção contra tentativas de login (rate limiting)

## Fórmulas Infantis

O sistema gerencia dois tipos de fórmula:
- **Fórmula 0-6 meses:** Para bebês de 0 a 5 meses e 29 dias
- **Fórmula 6-12 meses:** Para bebês de 6 a 11 meses e 29 dias

A atribuição é automática baseada na idade do bebê no momento do cadastro.

## Controle de Estoque

### Fluxo de Entrada
1. Recebimento de lotes (origem: SES-RJ)
2. Remanejamento entre UDMs
3. Devolução de maternidades

### Fluxo de Saída
1. Dispensação para responsáveis
2. Remanejamento para outras UDMs
3. Envio para maternidades
4. Registro de perdas (validade, avaria, etc.)

### Sistema de Alertas
- Estoque abaixo do mínimo configurado
- Lotes com validade inferior a 60 dias
- Notificações visuais no painel inicial

## Licença

GNU General Public License v3.0 - Veja o arquivo [LICENSE](LICENSE) para detalhes.

## Contato e Suporte

Para dúvidas, sugestões ou reportar problemas, abra uma issue no repositório.

---

**Nota:** Este sistema foi desenvolvido como parte de um projeto acadêmico/institucional para gerenciamento de fórmula infantil em unidades de saúde pública.
