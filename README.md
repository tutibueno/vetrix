# 🐾 Clínica Veterinária - Sistema de Gestão

Sistema de código aberto desenvolvido em PHP com CodeIgniter 4 para gestão de clínicas veterinárias. Ideal para profissionais da saúde animal que buscam organização, eficiência e controle da rotina clínica.

---

## 🚀 Funcionalidades

- Cadastro de clientes e pacientes (pets)
- Histórico clínico dos animais com ficha completa
- Controle de aplicação de vacinas
- Controle de Atendimentos
- Controle de prescrições com impressão das prescrições
- Controle de solicitação de exames com impressão das solicitaçoes
- Sistema multi-usuários

Roadmap:

- Agendamento de consultas
- Controle de serviços como banho e tosa.
- Controle financeiro



🛠️ Tecnologias Utilizadas
- PHP 8+
- CodeIgniter 4
- MySQL
- Bootstrap
- jQuery
- AdminLTE 

📦 Instalação
- Clone o repositório:

```bash
git clone https://github.com/tutibueno/clinica-veterinaria.git
cd clinica-veterinaria
composer install
```

- Crie um banco de dados MySQL (collation utf8mb4_generial_ci recomendada)
- Configure o ambiente: Copie o arquivo .env.example para .env ou env para .env e configure o banco de dados:

```pgsql
database.default.hostname = localhost
database.default.database = sua_base
database.default.username = seu_usuario
database.default.password = sua_senha
database.default.DBDriver = MySQLi
```

🗄️ Migrações e Seeds

Crie as tabelas com as migrations:

```bash
php spark migrate
```


### 👥 Usuários de Teste

Existe um seed que cria usuários para cada perfil do sistema:

```bash
php spark db:seed UserSeeder
```

Administrador

Usuario: admin
Senha: 123456

Veterinário

Usuario: veterinario
Senha: 123456

Recepcionista

Usuario: recepcao
Senha: 123456

⚠️ Altere as senhas em produção!


- Inicie o servidor local:
```bash
php spark serve
```

O sistema ficará disponível em:
👉 http://localhost:8080

Caso esteja hospedando o sistema altere o arquivo /app/Config/App.php conforme sua necessidade:

```php
public string $baseURL = 'http://seudominio.com.br/seuprojeto/';
```

👥 Contribuições
Contribuições são muito bem-vindas! Sinta-se à vontade para abrir issues, sugerir melhorias ou enviar pull requests.

📄 Licença
Este projeto está licenciado sob a MIT License. Veja o arquivo LICENSE para mais detalhes.

📣 Contato
Desenvolvido por Reginaldo Bueno
📧 Email: tuti.bueno@gmail.com
🐾 Instagram: @clinica.veterinaria.dev


---

🗑️ Limpeza de Sessões no Banco de Dados

Este projeto usa sessions armazenadas no banco (ci_sessions).
Como a configuração está com sessionExpiration = 0 (expiração infinita), as sessões antigas não expiram automaticamente.
Para evitar que a tabela cresça indefinidamente, criamos um comando customizado no CodeIgniter para limpeza periódica.

🔹 Executar manualmente

No terminal, dentro do diretório do projeto:

```bash 
php spark session:cleanup
```


👉 Por padrão, remove sessões com mais de 30 dias.

Se quiser um período diferente, passe o número de dias como argumento.
Exemplo: para limpar sessões mais antigas que 7 dias:


<pre> php spark session:cleanup 7 </pre>

🔹 Agendamento automático (cron job no Linux)

Você pode agendar a execução automática no cron.
Para editar o cron:

<pre> crontab -e </pre>

E adicionar, por exemplo, para rodar todo domingo às 3h da manhã:

<pre>  0 3 * * 0 /usr/bin/php /var/www/seuprojeto/spark session:cleanup 30 >> /var/www/seuprojeto/writable/logs/session_cleanup.log 2>&1
  </pre>


Isso vai:

Executar o comando session:cleanup

Manter somente sessões com até 30 dias

Registrar logs em writable/logs/session_cleanup.log

🔹 Boas práticas

Ajuste o número de dias conforme sua necessidade.

Se sua aplicação tiver muito tráfego, agende a limpeza com frequência maior (ex.: diariamente).

Para bancos muito grandes, considere criar índices na coluna timestamp da tabela ci_sessions para acelerar a exclusão.


## 🖼️ Capturas de Tela

> 

```markdown
![Tela de login](caminho/para/imagem-login.png)
![Dashboard](caminho/para/imagem-dashboard.png)


