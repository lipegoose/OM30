# OM30
<h1>Teste de Seleção para a OM30.</h1>

<p>Faça o Download deste Repositório na sua pasta do seu Projeto com os comandos <i>Git</i>:</p>
<pre><code>$ git clone https://github.com/lipegoose/OM30.git</code></pre>
<p>ou</p>
<pre><code>$ git clone git@github.com:lipegoose/OM30.git</code></pre>
<p>Após o Download do Git e com o Docker e o Docker-compose previamente instalados, na pasta raiz deste projeto, via Terminal, digite:</p>
<pre><code>$ sudo docker-compose up</code></pre>
<p>ou</p>
<pre><code>$ sudo docker-compose up -d</code></pre>
<p>Pronto! Tudo será instalado e ao final o Laravel -v 10 com PHP -v 7.4-fpm e com Postgres -v 13 em um Server nginx estará funcionando.</p>
<p>Antes de acessar, lembre-se de rodar o Comando <code>$ php artisan migrate</code></p>
<p>Para facilitar este comando pode ser rodado de dentro do Container através do Comando <code>$ sudo docker container exec -it om30-php-fpm-74 /bin/bash</code></p>
<p>Uma vez que vc está dentro do Container, acesse a pasta site (<code>$ cd site</code>) e então execute as Migrations.</p>
<p>Para acessar o site em seu navegador, basta digitar (na barra de endereço):</p>
<pre><code><a target="_blanck" href="http://localhost">http://localhost</a></code></pre>
<p>e para acessar o seu <i>Banco de Dados</i> com o <b>Adminer</b>, basta digitar (na barra de endereço do seu navegador):</p>
<pre><code><a target="_blanck" href="http://localhost:8080">http://localhost:8080</a></code></pre>
<h4>aaahhh.. lembre-se de renomear o seu arquivo .env.example XD.</h4>
<h3>pra isto, basta executar o seguinte código no seu terminal:</h3>
<pre><code>$ sudo cp www/site/.env.example www/site/.env</code></pre>
<p>Caso dê erro e vc não consiga visualizar o site, tente rodar os seguintes comandos com SUDO no seu terminal, na pasta raiz do Git:</p>
<pre><code>$ sudo chmod -R 777 www/site/bootstrap/cache/</code></pre>
<p>&&</p>
<pre><code>$ sudo chmod -R 777 www/site/storage/</code></pre>
<p>Agora, acesse o site novamente e teste avontade a Aplicação simples (sem Front-End elaborado) que criei.</p>
<p>Pronto! Vc já pode <i>Testar! <b>;-)</b></i></p>
<h5>e boa diversão. =)</h5>
<p>Para acessar o horizon, de dentro do Container execute o comando <code>$ php artisan horizon</code> e no navegador acesse: http://localhost/horizon</p>
<p>Se tiver qualquer dúvida, entre em contato.</p>
<p><b><i>#VamoJunto!</i></b></p>
<br>
<br>
<h4>Obrigado pela oportunidade!</h4>
<h3>Mr.Goose</h3>
 