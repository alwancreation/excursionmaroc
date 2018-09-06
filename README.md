Sql update : 
ALTER TABLE product ADD attached_file_id INT DEFAULT NULL;
ALTER TABLE product ADD CONSTRAINT FK_D34A04ADD62F4668 FOREIGN KEY (attached_file_id) REFERENCES asset (asset_id);
CREATE INDEX IDX_D34A04ADD62F4668 ON product (attached_file_id);


CREATE TABLE section_has_theme (section_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_EB18733D823E37A (section_id), INDEX IDX_EB1873359027487 (theme_id), PRIMARY KEY(section_id, theme_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
CREATE TABLE section_has_destination (section_id INT NOT NULL, destination_id INT NOT NULL, INDEX IDX_C2A444A7D823E37A (section_id), INDEX IDX_C2A444A7816C6140 (destination_id), PRIMARY KEY(section_id, destination_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;
ALTER TABLE section_has_theme ADD CONSTRAINT FK_EB18733D823E37A FOREIGN KEY (section_id) REFERENCES section (section_id) ON DELETE CASCADE;
ALTER TABLE section_has_theme ADD CONSTRAINT FK_EB1873359027487 FOREIGN KEY (theme_id) REFERENCES theme (theme_id) ON DELETE CASCADE;
ALTER TABLE section_has_destination ADD CONSTRAINT FK_C2A444A7D823E37A FOREIGN KEY (section_id) REFERENCES section (section_id) ON DELETE CASCADE;
ALTER TABLE section_has_destination ADD CONSTRAINT FK_C2A444A7816C6140 FOREIGN KEY (destination_id) REFERENCES destination (destination_id) ON DELETE CASCADE;
