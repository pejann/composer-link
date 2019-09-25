# Composer Link

Tem como objetivo facilitar o desenvolvimento local criando link
entre projetos via symlink.

Esse projeto é apenas um estudo, não possui testes e nenhuma funcionalidade
avançada.

Para utilizar o projeto crie um arquivo .linkrc.json na raiz do projeto
que deseja que os links sejam criados com o seguinte conteúdo:

```
{
  "vendor/library": "absolute/path/to/library/folder"
}
```

Para executar, adicione aos hooks de `post-install-cmd` e `post-update-cmd`
o comando `composer-link`:

```
{
  "scripts": {
    "post-install-cmd": "composer-link",
    "post-update-cmd": "composer-link"
  }
}
```
